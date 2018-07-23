<?php
	require_once("application/controllers/admin.php");

	class AdminportfolioController extends AdminController
	{

		function init(){

			$this->setLayout("admin");
			$this->Portfolio = new Model_Portfolio();
			$this->Gallery = new Model_Gallery();
			$this->view->galleryManagement = false;	
			$this->view->galleryThumbs = false;	
		}

		public function indexAction(){

			$this->view->portfolios = $this->Portfolio->get();	

		}

		public function editAction(){

			if (!empty(Router::$params[0])){

            	$id = Router::$params[0];
				$this->view->portfolio = $this->Portfolio->find($id);
				
				$this->view->gallery = $this->Gallery->getGallery($this->view->portfolio['gallery_id']);
				$this->view->galleryImages = $this->Gallery->getGalleryImages($this->view->portfolio['gallery_id']);
			}
		}

		public function createAction(){
			//
		}

		public function removeAction(){

			if (!empty(Router::$params[0])){

            	$id = Router::$params[0];

				DB::update("portfolios", "status=0", "id=".$id );
			}

			Alert::set("success", "Portfolio removed");
			Router::go('admin-portfolio');
		}

		public function saveAction(){
			if (empty($_POST)) {
				Router::go('admin-portfolio');
			}

			if (empty($_POST['title'])) {
				Alert::set("error", "Title are required");
				Router::go('admin-portfolio/create');
			}
			else {
				$_POST['created_at'] = date("Y-m-d H:i:s");
				$_POST['slug'] = $this->sanitizeSlug($_POST['title']);
				$_POST['gallery_id'] = $this->Gallery->addGallery($_POST['title'], '');
				
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

							if ($key == "video") {
								$video = File::upload($key, 'public/uploads/video');		
								foreach ($video as $value) {
						    		$elements[$key] = $value;
								}
							}
							else if ($key == "video_image") {
								$video = File::upload($key, 'public/uploads/video');		
								foreach ($video as $value) {
						    		$elements[$key] = $value;
								}
							}
							else if ($_FILES[$key]['type'] == "image/svg+xml") {
								$svg = File::upload($key, 'public/uploads/images');		
								foreach ($svg as $value) {
						    		$elements[$key] = $value;
								}
							}
							else {
								$upload = Image::upload($key, "public/uploads/images");
							
								if ($upload['status']) {
									$elements[$key] = $upload['uri'];
								}
							}
						}
					}
				}

				db::insert('portfolios', $elements);
				Alert::set("success", "Portfolio created");
				Router::go('admin-portfolio');
			}
		}

		public function updateAction()
		{
			if (!empty(Router::$params[0])) {

            	$id = Router::$params[0];
				$this->view->portfolio = $this->Portfolio->find($id);
				$_POST['slug'] = $this->sanitizeSlug($_POST['title']);

				if (empty($this->view->portfolio['gallery_id'])) {
					$_POST['gallery_id'] = $this->Gallery->addGallery($this->view->portfolio['title'], '');
				}

				if (!empty($this->view->portfolio['id'])) {
					if (empty($_POST['title'])) {
						Alert::set("error", "Title are required");
						Router::go('admin-portfolio/edit/'.$id);
					}
					else {
						if ( isset($_POST['delete_thumb']) || isset($_POST['delete_logo']) || isset($_POST['delete_video']) || isset($_POST['delete_video_image'])) {
							if ($_POST['delete_thumb'] == 1 && !empty($this->view->portfolio['thumb'])) {

								$delete = unlink('public/'.$this->view->portfolio['thumb']);
								$_POST['thumb'] = "";
								unset($_POST['delete_thumb']);
							}
							else {
								unset($_POST['delete_thumb']);
							}

							if ($_POST['delete_logo'] == 1 && !empty($this->view->portfolio['logo'])) {

								$delete = unlink('public/'.$this->view->portfolio['logo']);
								$_POST['logo'] = "";
								unset($_POST['delete_logo']);
							}
							else {
								unset($_POST['delete_logo']);
							}

							if ($_POST['delete_video'] == 1 && !empty($this->view->portfolio['video'])) {

								$delete = unlink('public/'.$this->view->portfolio['video']);
								$_POST['video'] = "";
								unset($_POST['delete_video']);
							}
							else {
								unset($_POST['delete_video']);
							}

							if ($_POST['delete_video_image'] == 1 && !empty($this->view->portfolio['video_image'])) {

								$delete = unlink('public/'.$this->view->portfolio['video_image']);
								$_POST['video_image'] = "";
								unset($_POST['delete_video_image']);
							}
							else {
								unset($_POST['delete_video_image']);
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

									if ($key == "video") {
										$video = File::upload($key, 'public/uploads/video');		
										foreach ($video as $value) {
								    		$elements[$key] = $value;
										}
									}
									else if ($key == "video_image") {
										$video = File::upload($key, 'public/uploads/video');		
										foreach ($video as $value) {
								    		$elements[$key] = $value;
										}
									}
									else if ($_FILES[$key]['type'] == "image/svg+xml") {
										$svg = File::upload($key, 'public/uploads/images');		
										foreach ($svg as $value) {
								    		$elements[$key] = $value;
										}
									}
									else {
										$upload = Image::upload($key, "public/uploads/images");
									
										if ($upload['status']) {
											$elements[$key] = $upload['uri'];
										}
									}
								}
							}
						}						

						db::update("portfolios", $elements, "id=".(int)$id );
						Alert::set("success", "Portfolio updated");
						Router::go('admin-portfolio/edit/'.$id);
					}
				}
				else {
					Alert::set("error", "Portfolio not found!");
					Router::go('admin-portfolio');
				}
			}
			else {
				Alert::set("error", "Page not found!");
				Router::go('admin-portfolio');
			}
		}		

		public function sanitizeSlug($slug)
	    {
	        return trim(strtolower(preg_replace(['/[^a-zA-Z0-9\/]/', '/\/+/', '/-+/'], ['-', '/', '-'], $slug)), '-');
	    }

	}