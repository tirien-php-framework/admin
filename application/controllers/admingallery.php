<?php
	require_once("application/controllers/admin.php");

	class AdmingalleryController extends AdminController
	{

		function init(){

			$this->setLayout("admin");
			$this->Gallery = new Model_Gallery();
			$this->view->galleryManagement = false;	
			$this->view->galleryThumbs = false;	

		}

		public function indexAction(){

			$this->view->galleries = $this->Gallery->getAllGalleries();	

		}

		public function editAction(){

			if (!empty(Router::$params[0])){

            	$id = Router::$params[0];
				$this->view->gallery = $this->Gallery->getGallery($id);
				$this->view->galleryImages = $this->Gallery->getGalleryImages($id);

			}

		}

		public function addAction(){

			$this->Gallery->addGallery();
			Router::go( "admin-gallery");
			
		}

		public function removeAction(){

			if (!empty(Router::$params[0])){

            	$id = Router::$params[0];
				$this->Gallery->removeGallery($id);

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
			$id = (int)Router::$params[0];
			$gallery = $this->Gallery->getGallery($id);

			$data = $_POST;
			// vd($data['order'],1);

			// $this->Gallery->saveGallery($id, $data);

			if (isset( $data['order']) ) {

				foreach ($data['order'] as $orderNumber=>$imageId) {
					$galleryimage = new Model_GalleryImage();
					$galleryimage->load($imageId);
					$galleryimage->setOrderNumber($orderNumber);
					$galleryimage->save();
				};
				
			}

			Alert::set("success","Changes saved");
			Router::go('admin-gallery/edit/'.$id);
			
		}

	}