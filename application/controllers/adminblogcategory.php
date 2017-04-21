<?php
	require_once("application/controllers/admin.php");

	class AdminblogcategoryController extends AdminController
	{

		function init(){

			$this->setLayout("admin");
			$this->Blog = new Model_Blogpost();
			$this->BlogPostComment = new Model_Blogpostcomment();
			$this->BlogCategory = new Model_Blogcategory();
		}

		public function indexAction(){

			$this->view->posts = $this->Blog->get();	
			$this->view->comments = $this->BlogPostComment->get();	
			$this->view->categories = $this->BlogCategory->get();	

		}

		public function createAction() {
			$this->view->categories = $this->BlogCategory->get();	
			$this->view->category = array(
				'title' => '',
				'subtitle' => '',
				'excerpt' => '',
				'description' => '',
				'thumb' => '',
				'menu_order' => '',
				'seo_title' => '',
				'seo_description' => '',
				'seo_keyword' => '',
			);

			$this->setView('adminblogcategory/category.php');
		}

		public function editAction(){

			if (!empty(Router::$params[0])){

            	$id = Router::$params[0];
				$this->view->categories = $this->BlogCategory->get();	
				$this->view->category = $this->BlogCategory->find($id);

				$this->setView('adminblogcategory/category.php');
			}
		}

		public function saveAction() {
			$id = Router::$params[0];

			if (empty($_POST)) {
				Router::go('admin-map');
			}

			if (empty($_POST['title'])) {
				Alert::set("error", "Title are required");
					
				if ($id == "new") {
					Router::go('admin-blogcategory/create');
				}
				else {
					Router::go('admin-blogcategory/edit/'.$id);
				}
			}
			else {
				$_POST['created_at'] = date("Y-m-d H:i:s");

				if (!empty($_POST['delete_thumb']) || !empty($_POST['delete_pdf'])) {
					$this->view->category = $this->BlogCategory->find($id);

					if ($_POST['delete_thumb'] == 1 && !empty($this->view->category['thumb'])) {
						$delete = unlink('public/'.$this->view->category['thumb']);

						$_POST['thumb'] = "";
						unset($_POST['delete_thumb']);
					}
					else {
						unset($_POST['delete_thumb']);
					}

					if ($_POST['delete_pdf'] == 1 && !empty($this->view->category['pdf'])) {
						$delete = unlink('public/'.$this->view->category['pdf']);

						$_POST['pdf'] = "";
						unset($_POST['delete_pdf']);
					}
					else {
						unset($_POST['delete_pdf']);
					}
				}

				$elements = $_POST;

				if ( !empty($_FILES['elements'])) {
					$files = $_FILES['elements'];
				
					foreach ( $files['tmp_name'] as $key => $tmp_name ) {
						$_FILES[$key] = array(
							"name" => $files['name'][$key],
							"type" => $files['type'][$key],
							"tmp_name" => $files['tmp_name'][$key],
							"error" => $files['error'][$key],
							"size" => $files['size'][$key]
							);
						if ($_FILES[$key]['name'] != '') {

							list( , $temp ) = explode('.', $_FILES[$key]['name']);
							if ($temp !='pdf') {

								$upload = Image::upload($key, "public/uploads/images");
								
								if ($upload['status']) {
									$elements[$key] = $upload['uri'];
								}
							}
							else {
								$pdf = File::upload($key, 'public/uploads/pdf');		
								foreach ($pdf as $value) {
						    		$elements[$key] = $value;
								}
							}
						}
					}
				}

				if ($id == "new") {
					db::insert('blog_categories', $elements);
					Alert::set("success", "New Category Added");
					Router::go('admin-blogcategory');
				}
				else {
					db::update('blog_categories', $elements, "id=".$id);
					Alert::set("success", "Category Updated");
					Router::go('admin-blogcategory/edit/'.$id);
				}
			}
		}	

		public function removeAction(){

			if (!empty(Router::$params[0])){

            	$id = Router::$params[0];
            	
            	$posts = $this->BlogCategory->getBlogPosts($id);
            	foreach ($posts as $post) {
					DB::update("blog_posts", "status=0", "id=".$post['id'] );
            	}

				DB::update("blog_categories", "status=0", "id=".$id );
			}

			Alert::set("success", "Category removed");
			Router::go('admin-blogcategory');
		}
	}