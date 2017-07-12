<?php
	require_once("application/controllers/admin.php");

	class AdmingalleryimagesController extends AdminController {
		public function indexAction(){

		}

		public function editAction(){

			$galleryId  = Router::$params[0];
			$imageId = isset(Router::$params[1]) ? Router::$params[1] : null ;

			if (!empty($imageId)){
				$galleryimage = new Model_GalleryImage();
				$galleryimage->load($imageId);
				$this->view->galleryimage = $galleryimage;
				$this->view->imageId = $imageId;
			}
			$this->view->galleryId = $galleryId;
			$Gallery = new Model_Gallery();
			
			$this->view->gallery = $Gallery->getGallery($galleryId);

		}

		public function saveAction(){
			ob_start();
			$galleryId  = Router::$params[0];
			$imageId = isset(Router::$params[1]) ? Router::$params[1] : null;
			$gallery_width = $_POST['gallery_width'];
			$gallery_height = $_POST['gallery_height'];
			$redirect_uri = $_POST['redirect_uri'];
			$phone_width = 640;
			$phone_height = 1200;

			if ( !empty($_FILES['source']['name'][0]) ){
				
				$files = is_array($_FILES['source']['name']) ? $_FILES['source']['name'] : array(0);

				foreach ($files as $id => $name) {

					$galleryimage = new Model_GalleryImage();
					$galleryimage->setParentId($galleryId);

					if( !is_array($_FILES['source']['name']) ) $id = null;

					$upload = Image::upload('source', 'public/uploads/gallery', $id);

					if($upload['status']){
						$file = $upload['filename'];
					}

					if ($file || isset($imageId)){

						if ($file) {
							$image = true;
						}else{
							$image = false;
						}

						$ImagePath = "public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."gallery".DIRECTORY_SEPARATOR.$file;

						$size = getimagesize($ImagePath);
						if ( $size[0] < $phone_width ) {
							$phone_width = $size[0];
						}

						$phonePath = "public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."gallery".DIRECTORY_SEPARATOR."phone".DIRECTORY_SEPARATOR.$file;

						if (!file_exists("public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."gallery".DIRECTORY_SEPARATOR."phone")) {
							mkdir("public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."gallery".DIRECTORY_SEPARATOR."phone", 0777);
						}
		
						if (!file_exists($phonePath)) 
						{
							Image::fit( $ImagePath, $phone_width, $phone_height, $phonePath );
						}

						if($_POST['manual_crop']!="true"){
							Image::fill( $ImagePath, $gallery_width, $gallery_height );
						}		

						if($image){
							$search = array(
								"public".DIRECTORY_SEPARATOR,
								DIRECTORY_SEPARATOR
								);
							
							$replace = array(
								'',
								'/'
								);

							$image = str_replace($search, $replace, $ImagePath);
							$phone = str_replace($search, $replace, $phonePath);

							$galleryimage->setSource($image);
							$galleryimage->setPhone($phone);
							$galleryimage->setTitle(!empty($_POST['title']) ? $_POST['title'] : "");
							$galleryimage->setText(!empty($_POST['text']) ? $_POST['text'] : "");
							$galleryimage->setVisible(1);

						}

					}

					$galleryimage->save();

					}

				}
			else {
				$galleryimage = new Model_GalleryImage();

				if (!empty($_POST['delete_thumb']) && $_POST['delete_thumb'] == 1) {
					$delete = unlink('public/'.$this->view->gallery['thumb']);

					$_POST['thumb'] = "";
					unset($_POST['delete_thumb']);
				}
				else {
					unset($_POST['delete_thumb']);
				}

				if (!empty($_POST['delete_blur']) && $_POST['delete_blur'] == 1) {
					$delete = unlink('public/'.$this->view->gallery['blur']);

					$_POST['blur'] = "";
					unset($_POST['delete_blur']);
				}
				else {
					unset($_POST['delete_blur']);
				}

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
									
							if ($temp != 'svg') {
								if ($key == 'thumb') {
									$upload = Image::upload($key, "public/uploads/images/thumb");
									
									if ($upload['status']) {
										$thumb = $upload['uri'];
									}
								}
								else {
									$upload = Image::upload($key, "public/uploads/images/blur");
									
									if ($upload['status']) {
										$blur = $upload['uri'];
									}
								}
							}
							else {
								if ($key == 'thumb') {
									$upload = File::upload($key, "public/uploads/images/thumb");
									
									foreach ($upload as $value) {
							    		$thumb = $value;
									}
								}
								else {
									$upload = File::upload($key, "public/uploads/images/blur");
									
									foreach ($upload as $value) {
							    		$blur = $value;
									}
								}
							}
						}
					}
				}

				if ( isset($imageId) ) {
					$galleryimage->load($imageId);
					$galleryimage->setId($imageId);
			}

				$galleryimage->setParentId($galleryId);
				$galleryimage->setThumb(isset($thumb) ? $thumb : '');
				$galleryimage->setBlur(isset($blur) ? $blur : '');
				$galleryimage->setTitle($_POST['title']);
				$galleryimage->setText($_POST['text']);
				$galleryimage->save();
			}


			if($_POST['manual_crop']=="true"){
				Router::go('admin-crop/?image='.$image.'&width='.$gallery_width.'&height='.$gallery_height.'&thumb_width='.$thumb_width.'&thumb_height='.$thumb_height.'&redirect_uri='.$redirect_uri.'&gallery=1');
			}

			Alert::set("success", "Changes saved");
			Router::go($_POST['redirect_uri']);

		}

		public function removeAction(){

			$galleryId = Router::$params[0];
			$imageId = isset(Router::$params[1]) ? Router::$params[1] : null;

			if (!empty($imageId)){
				$galleryimage = new Model_GalleryImage();
				$galleryimage->load($imageId);
				$galleryimage->remove();
			}

			Alert::set("success", "Image removed");
			Router::go('admin-gallery/edit/'.$galleryId);
		}

		public function saveorderAction(){

			foreach ($_POST['order'] as $orderNumber=>$imageId) {
				$galleryimage = new Model_GalleryImage();
				$galleryimage->load($imageId);
				$galleryimage->setOrderNumber($orderNumber);
				$galleryimage->save();
			};
			
			Alert::set("success", "Order saved");
			Router::go('admin-gallery');

		}
	}