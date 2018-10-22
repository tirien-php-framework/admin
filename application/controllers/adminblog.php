<?php
	require_once("application/controllers/admin.php");

	class AdminblogController extends AdminController
	{

		function init(){

			$this->setLayout("admin");
			$this->Blog = new Model_BlogPost();
			$this->BlogPostComment = new Model_BlogPostComment();
			$this->BlogCategory = new Model_BlogCategory();
		}

		public function indexAction(){

			$this->view->posts = $this->Blog->getDesc();	
			$this->view->comments = $this->BlogPostComment->get();	
			$this->view->categories = $this->BlogCategory->get();	

		}

		public function createAction() {
			$this->view->categories = $this->BlogCategory->get();	
			$this->view->post = array(
				'title' => '',
				'sub_title' => '',
				'uri_id' => '',
				'content' => '',
				'autor' => '',
				'description' => '',
				'pdf' => '',
				'thumb' => '',
				'excerpt' => '',
				'meta_title' => '',
				'meta_description' => '',
				'meta_keyword' => '',
				'blog_category_id' => '',
				'created_at' => date("Y-m-d H:i:s"),
				'visible' => '1'
			);

			$this->setView('adminblog/post.php');
		}

		public function editAction(){

			if (!empty(Router::$params[0])){

            	$id = Router::$params[0];
				$this->view->categories = $this->BlogCategory->get();	
				$this->view->post = $this->Blog->find($id);

				$this->setView('adminblog/post.php');
			}
		}

		public function saveAction() {
			$id = Router::$params[0];

			if (empty($_POST)) {
				Router::go('admin-map');
			}

			if (empty($_POST['title']) || empty($_POST['blog_category_id'])) {
				Alert::set("error", "Title and blog_category_id are required");
					
				if ($id == "new") {
					Router::go('admin-blog/create');
				}
				else {
					Router::go('admin-blog/edit/'.$id);
				}
			}
			else {
				if ($id == "new") {
					$_POST['created_at'] = date("Y-m-d H:i:s");
				}
				if (!empty($_POST['delete_thumb']) || !empty($_POST['delete_pdf'])) {
					$this->view->post = $this->Blog->find($id);

					if ($_POST['delete_thumb'] == 1 && !empty($this->view->post['thumb'])) {
						$delete = unlink('public/'.$this->view->post['thumb']);

						$_POST['thumb'] = "";
						unset($_POST['delete_thumb']);
					}
					else {
						unset($_POST['delete_thumb']);
					}

					if ($_POST['delete_pdf'] == 1 && !empty($this->view->post['pdf'])) {
						$delete = unlink('public/'.$this->view->post['pdf']);

						$_POST['pdf'] = "";
						unset($_POST['delete_pdf']);
					}
					else {
						unset($_POST['delete_pdf']);
					}
				}

				$_POST['slug'] = $this->sanitizeSlug($_POST['title']);

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

							$temp = explode('.', $_FILES[$key]['name']);
							if ($temp[count($temp) - 1] != 'pdf') {

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
					db::insert('blog_posts', $elements);
					Alert::set("success", "New Blog Added");
					Router::go('admin-blog');
				}
				else {
					db::update('blog_posts', $elements, "id=".$id);
					Alert::set("success", "Blog Updated");
					Router::go('admin-blog/edit/'.$id);
				}
			}
		}	

		public function removeAction(){

			if (!empty(Router::$params[0])){

            	$id = Router::$params[0];
				DB::update("blog_posts", "status=0", "id=".$id );
			}

			Alert::set("success", "Blog removed");
			Router::go('admin-blog');
		}

		public function sanitizeSlug($slug)
	    {
	        $newSlug = trim(strtolower(preg_replace(['/[^a-zA-Z0-9\/]/', '/\/+/', '/-+/'], ['-', '/', '-'], $slug)), '-');
	        
	        if (!empty($this->Blog->where('slug', $newSlug))) {
	        	return $this->sanitizeSlug($newSlug.'-1');
	        }

	        return $newSlug;
	    }
	}