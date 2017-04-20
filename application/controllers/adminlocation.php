<?php
	require_once("application/controllers/admin.php");

	class AdminlocationController extends AdminController
	{

		function init(){

			$this->setLayout("admin");
			$this->Location = new Model_Location();
			$this->Map = new Model_Map();
			$this->view->galleryManagement = false;	
			$this->view->galleryThumbs = false;	

		}

		public function indexAction(){

			$this->view->locations = $this->Location->get();	

		}

		public function editAction(){

			if (!empty(Router::$params[0])){

            	$id = Router::$params[0];
				$this->view->location = $this->Location->find($id);
				$this->view->maps = $this->Map->get();
				// $this->view->galleryImages = $this->Location->getGalleryImages($id);
			}

		}

		public function createAction(){
			$this->view->maps = $this->Map->get();

			if (!count($this->view->maps)) {
				Alert::set('error', 'Add map first');
				Router::go('admin-map');
			}
		}

		public function removeAction(){

			if (!empty(Router::$params[0])){

            	$id = Router::$params[0];
				$this->Location->removeGallery($id);

			}

			Router::go('admin-gallery');

		}

		public function saveorderAction(){

			$this->disableView();
			$order = $_POST['order'];				

			foreach ($order as $order_number=> &$id) {
				$order_number +=1; 
				db::update("galleries", 'order_number='.(int)$order_number, "id=".(int)$id );
			}

			echo "Success";

		}

		public function saveAction(){
			if (empty($_POST)) {
				Router::go('admin-map');
			}

			if (empty($_POST['title']) || empty($_POST['latitude']) || empty($_POST['longitude'])) {
				Alert::set("error", "Title, longitude and latitude are required");
				Router::go('admin-location/create');
			}
			else {
				if ($_POST['map_id'] == 0) {
					Alert::set("error", "Please select map");
					Router::go('admin-location/create');
				}
				else {
					$_POST['created_at'] = date("Y-m-d H:i:s");
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

								$upload = Image::upload($key, "public/uploads/images");
								
								if ($upload['status']) {
									$elements[$key] = $upload['uri'];
								}
							}
						}
					}

					db::insert('locations', $elements);
					Alert::set("success", "Map created");
					Router::go('admin-location');
				}
			}
		}

		public function updateAction(){

			if (!empty(Router::$params[0])) {

            	$id = Router::$params[0];
				$this->view->location = $this->Location->find($id);

				if (!empty($this->view->location['id'])) {
					if (empty($_POST['title']) || empty($_POST['latitude']) || empty($_POST['longitude'])) {
						Alert::set("error", "Title, longitude and latitude are required");
						Router::go('admin-location/edit/'.$id);
					}
					else {
						if ($_POST['map_id'] == 0) {
							Alert::set("error", "Please select map");
							Router::go('admin-location/edit/'.$id);
						}
						else {
							if (isset($_POST['delete_marker_image']) || isset($_POST['delete_thumb_image']) || isset($_POST['delete_image'])) {
								if ($_POST['delete_marker_image'] == 1 && empty($this->view->location['marker_image'])) {

									$delete = unlink('public/'.$this->view->location['marker_image']);
									$_POST['marker_image'] = "";
									unset($_POST['delete_marker_image']);
								}
								else {
									unset($_POST['delete_marker_image']);
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

										$upload = Image::upload($key, "public/uploads/images");
										
										if ($upload['status']) {
											$elements[$key] = $upload['uri'];
										}
									}
								}
							}

							db::update("locations", $elements, "id=".(int)$id );
							Alert::set("success", "Location updated");
							Router::go('admin-location/edit/'.$id);
						}
					}
				}
				else {
					Alert::set("error", "Location not found!");
					Router::go('admin-location');
				}
			}
			else {
				Alert::set("error", "Page not found!");
				Router::go('admin-location');
			}
		}		
	}