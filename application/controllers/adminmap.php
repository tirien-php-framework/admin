<?php
	require_once("application/controllers/admin.php");

	class AdminmapController extends AdminController
	{

		function init(){

			$this->setLayout("admin");
			$this->Location = new Model_Location();
			$this->Map = new Model_Map();
			$this->view->galleryManagement = false;	
			$this->view->galleryThumbs = false;	

		}

		public function indexAction(){

			$this->view->maps = $this->Map->get();	

		}

		public function editAction(){

			if (!empty(Router::$params[0])){

            	$id = Router::$params[0];
				$this->view->map = $this->Map->find($id);
				// $this->view->galleryImages = $this->Location->getGalleryImages($id);
			}
		}

		public function createAction(){
			//
		}

		public function removeAction(){

			if (!empty(Router::$params[0])){

            	$id = Router::$params[0];
				$this->Location->removeGallery($id);

			}

			Alert::set("success", "Map removed");
			Router::go('admin-map');
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
				Router::go('admin-map/create');
			}
			else {
				$_POST['created_at'] = date("Y-m-d H:i:s");
				db::insert('maps', $_POST);
				Alert::set("success", "Map created");
				Router::go('admin-map');
			}
		}

		public function updateAction(){

			if (!empty(Router::$params[0])) {

            	$id = Router::$params[0];
				$this->view->map = $this->Map->find($id);

				if (!empty($this->view->map['id'])) {
					if (empty($_POST['title']) || empty($_POST['latitude']) || empty($_POST['longitude'])) {
						Alert::set("error", "Title, longitude and latitude are required");
						Router::go('admin-map/edit/'.$id);
					}
					else {
						db::update("maps", $_POST, "id=".(int)$id );
						Alert::set("success", "Map updated");
						Router::go('admin-map/edit/'.$id);
					}
				}
				else {
					Alert::set("error", "Map not found!");
					Router::go('admin-map');
				}
			}
			else {
				Alert::set("error", "Page not found!");
				Router::go('admin-map');
			}
		}		

	}