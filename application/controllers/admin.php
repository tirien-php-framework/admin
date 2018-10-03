<?php 
	define("ELEMENT_TYPE_TEXTLINE", 1);
	define("ELEMENT_TYPE_TEXTAREA", 2);
	define("ELEMENT_TYPE_IMAGE", 	3);
	define("ELEMENT_TYPE_GALLERY", 	4);
	define("ELEMENT_TYPE_FILE", 	5);
	define("ELEMENT_TYPE_HTML", 	6);
	define("ELEMENT_TYPE_SUBTITLE", 7);

	class AdminController extends Core
	{

		// must be final constructor, because init() can be overwritten
		final function __construct(){

			parent::__construct();
			if(!Auth::check() && Router::$action != "login") Auth::loginPage();
			$this->setLayout('admin');
		
		}

		function loginAction(){
			$this->setLayout("login");

			if (!isset($_SESSION['login'])) {
				$_SESSION['login']['lock_login'] = 0; 
				$_SESSION['login']['forgot_password'] = 0;
			}

			// $u = new Model_User();
			// $new_user = $u->createUser($_POST);
			// vd($new_user,1);

			$userModel = new Model_User();

			if (!empty($_POST)) {
				// CHECK LOGIN
				if (!empty($_POST['username']) && isset($_POST['password']) && Auth::login( $_POST['username'], $_POST['password'], @$_POST['remember_me'] )) { 

					$_SESSION['login']['lock_login'] = 0;
					$_SESSION['login']['forgot_password'] = 0;

					Header("Location: ".Path::urlBase('admin'));
					die();
				}
				else {
					// LOCK LOGIN
					if ($_SESSION['login']['lock_login'] >= 5) {
						die();
					}
					
					$_SESSION['login']['lock_login'] ++;
					$_SESSION['login']['forgot_password'] ++;

					$this->view->error = "bad login";
				}
			}
		}

		function logoutAction(){
			Auth::logout();

			Header("Location: ".Path::urlBase('admin'));
			die();
		}

		public function indexAction(){
			Router::go( ml::p()."admin/page/" );	
		}

		public function pageAction(){
			$Page = new Model_Page();

			if( Router::$params[0] == "save" ){
				$elements = $_POST['elements'];

				if( !empty($_FILES['elements'])){
					$files = $_FILES['elements'];
				
					foreach( $files['tmp_name'] as $key => $tmp_name ){
						$_FILES[$key] = array(
							"name" => $files['name'][$key],
							"type" => $files['type'][$key],
							"tmp_name" => $files['tmp_name'][$key],
							"error" => $files['error'][$key],
							"size" => $files['size'][$key]
							);
						if ($_FILES[$key]['name'] != '') {
							list( , $temp ) = explode('.', $_FILES[$key]['name']);										

							if ($_FILES[$key]['type'] == "video/mp4") {
								$video = File::upload($key, 'public/uploads/videos');		
								foreach ($video as $value) {
						    		$elements[$key] = $value;
								}
							}
							else if ($_FILES[$key]['type'] == "image/svg+xml") {
								$svg = File::upload($key, 'public/uploads/images');		
								foreach ($svg as $value) {
						    		$elements[$key] = $value;
								}
							} else if ($temp !='pdf') {
								$upload = Image::upload($key, "public/uploads/images");
								
								if ($upload['status']) {
									$elements[$key] = $upload['uri'];
									$file = $upload['filename'];

									$phone_width = 640;
									$phone_height = 1200;

									$ImagePath = "public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR.$file;

									$size = getimagesize($ImagePath);
									if ( $size[0] < $phone_width ) {
										$phone_width = $size[0];
									}

									$phonePath = "public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."mobile".DIRECTORY_SEPARATOR.$file;

									if (!file_exists("public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."mobile")) {
										mkdir("public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."mobile", 0777);
									}
					
									if (!file_exists($phonePath)) 
									{
										Image::fit( $ImagePath, $phone_width, $phone_height, $phonePath );
									}
								}
							} else {
								$pdf = File::upload($key, 'public/uploads/pdf');		
								foreach ($pdf as $value) {
						    		$elements[$key] = $value;
								}
							}	
						}
					}
				}
				$this->view->pageId = Router::$params[1];

				if($Page->updateElements($elements)){
					Alert::set("success","Successfully saved");
				}
				else{
					Alert::set("error","Error saving");
				}

				Router::go( ml::p()."admin/page/edit/" . $this->view->pageId );

			}

			if( Router::$params[0] == "edit" ){
				$this->view->pageId = Router::$params[1];
				$this->view->elements = $Page->getElements( $this->view->pageId );
				$this->setView("admin/page_edit.php");
				$this->view->pageTitle = $Page->getPagesTitleById( $this->view->pageId );
			}
			else{
				$this->view->pages = $Page->getAll();
			}

			if ( Router::$params[0] == "add-element" ) {

				if (!empty($_POST['title'] && !empty($_POST['type_id']))) {
					db::insert('page_element', $_POST);
					Router::go( ml::p()."admin/page/edit/" . $_POST['page_id'] );
				}
				else {
					Alert::set("error", "Name are required");
					Router::go( ml::p()."admin/page/edit/" . $_POST['page_id'] );
				}
			}

			if ( Router::$params[0] == "add-page" ) {
				if (!empty($_POST['title'] || !empty($_POST['type_id']))) {
					db::insert('page', $_POST);
					Router::go( ml::p()."admin/page/" );
				}
				else {
					Alert::set("error", "Name are required");
					Router::go( ml::p()."admin/page/" );
				}
			}
			if ( Router::$params[0] == "save-order" ) {
				$this->disableView();

				$order = $_POST['order'];				
				foreach ($order as $order_number => $id) {
					DB::update('page_element', ['order_number' => (int)$order_number], ['id' => $id]);
				}

				echo "Success";
			}
		}


		public function tinyUploadImageAction(){

			$this->disableLayout();

			if(isset($_FILES['file'])){

				$allowedExts = array("jpg", "jpeg", "gif", "png");
				$files = $_FILES['file'];

				foreach ($files['tmp_name'] as $key => $value) {

					// vd($_FILES["file"]["size"][$key]); die();
					$_FILES[$key] = array(
					"name" => $files['name'][$key],
					"type" => $files['type'][$key],
					"tmp_name" => $files['tmp_name'][$key],
					"error" => $files['error'][$key],
					"size" => $files['size'][$key]
					);


					$tmp = explode('.', $_FILES["file"]["name"][$key]);
					$extension = end($tmp);

					if ((($_FILES["file"]["type"][$key] == "image/gif")
					|| ($_FILES["file"]["type"][$key] == "image/jpeg")
					|| ($_FILES["file"]["type"][$key] == "image/png")
					|| ($_FILES["file"]["type"][$key] == "image/pjpeg"))
					&& ($_FILES["file"]["size"][$key] < 4000000)
					&& in_array($extension, $allowedExts))
					{
						if ($_FILES["file"]["error"][$key] > 0){
					 		echo "Return Code: " . $_FILES["file"]["error"][$key] . "<br>";
						}
						else {

							$upload = Image::upload($key, "public/uploads/tiny/");
							
							if($upload['status']){
								$this->view->uploadedImage = $upload['uri'];
							}

						}
					}
					else {
						echo "Invalid file";
					}

				}

			}

		}

		public function tinyDeleteImageAction(){

			$this->disableLayout();
			$this->disableView();

			if (!empty($_POST['path']) && file_exists("public/uploads/tiny/".$_POST['path'])) {
				$_POST['path'] = str_replace("./", "", $_POST['path']);
				unlink("public/uploads/tiny/".$_POST['path']);
			}

		}	

		public function setLeadTable()
		{
			$db_config = array(
				"type" => 'sqlite',
				"file" => 'application/databases/leads.db'
				);
			
			DB::init($db_config);
		}
		
		public function leadsAction()
		{
			// SET LEAD TABLE
			$this->setLeadTable();

			$filter = !empty(Router::$params[0]) ? "AND lead_type_id=".(int)Router::$params[0] : "";

			$this->view->leads = DB::query( "SELECT * FROM lead WHERE status=1 ".$filter." ORDER BY dti DESC" );

			foreach ($this->view->leads as &$lead) {
				$lead['data'] = json_decode($lead['data'],1);
			}
			$this->setView("admin/leads.php");
		}

		public function leadAction()
		{
			// SET LEAD TABLE
			$this->setLeadTable();

			if( !empty(Router::$params[0]) ){
				$id = (int)Router::$params[0];
				$this->view->lead = DB::query( "SELECT * FROM lead WHERE status=1 AND id=? ORDER BY dti DESC", $id, true );
				if( !empty($this->view->lead) ){
					$this->view->lead['data'] = json_decode($this->view->lead['data'],1);
				}
				else{
					Router::pageNotFound();
				}
			}
		}

		public function leadsSettingAction()
		{
			// SET LEAD TABLE
			$this->setLeadTable();

			if (!empty($_POST)) {
				DB::update('lead_setting', $_POST, 'id=1');
			}

			$this->view->leadsSetting = DB::query( "SELECT * FROM lead_setting WHERE id=1 LIMIT 1" );

			if( !empty($this->view->leadsSetting) ){
				$this->view->leadsSetting = $this->view->leadsSetting[0];
			}
			else{
				Router::pageNotFound();
			}
		}

		public function leadDeleteAction()
		{
			// SET LEAD TABLE
			$this->setLeadTable();

			$this->disableView();

			if( !empty(Router::$params[0]) ){
				$id = (int)Router::$params[0];
				DB::update( "lead", "status=0", "id=".$id );
			}

			Router::go("admin/leads");
		}

		public function exportXlsxAction()
		{
			// SET LEAD TABLE
			$this->setLeadTable();

			$this->disableLayout();
			$this->disableView();

			$lead_type = (int)Router::$params[0];

			if( !empty(Router::$params[0]) ){
				$data = DB::query( "SELECT data, dti FROM lead WHERE status=1 AND lead_type_id=?", $lead_type );
			}
			else{
				$data = DB::query("SELECT data, dti FROM lead WHERE status=1");
			}

			if( !empty($data) ){
				foreach($data as $row_key => &$row){ 
					$dti = $row['dti'];
					$row = json_decode($row['data'], 1);
					$row['dti'] = $dti;
				}

				Export::toXLSX($data);
			}
		}

		public function exportCsvAction()
		{
			// SET LEAD TABLE
			$this->setLeadTable();

			$this->disableLayout();
			$this->disableView();

			$lead_type = (int)Router::$params[0];

			if( !empty(Router::$params[0]) ){
				$data = DB::query( "SELECT data, dti FROM lead WHERE status=1 AND lead_type_id=?", $lead_type );
			}
			else{
				$data = DB::query("SELECT data, dti FROM lead WHERE status=1");
			}

			if( !empty($data) ){
				foreach($data as $row_key => &$row){ 
					$dti = $row['dti'];
					$row = json_decode($row['data'], 1);
					$row['dti'] = $dti;
				}
							
				Export::toXLScsv($data);
			}
		}

		public function imageWithMarkersAction(){
			$Imagewithmarkers = new Model_Imagewithmarker();
			$this->view->imagewithmarkers = $Imagewithmarkers->getAll();

			$Imageformarker = new Model_Imageformarker();
			$this->view->imageformarker = $Imageformarker->get();

			if (Router::$params[0] == "add") {
				DB::insert("imagewithmarkers", array(
					"x" => 0,
					"y" => 0
				));

				Router::go( "admin/imagewithmarkers");
			}
			else if (Router::$params[0] == "delete") {
				$id = Router::$params[1];
				DB::update("imagewithmarkers", "status=0", "id=".$id );

				Router::go("admin/imagewithmarkers");
			}


			if (!empty($_POST['locations'])) {
				$locations = $_POST['locations']; 
				$locationId = Router::$params[0];

				$files = !empty($_FILES['locations']) ? $_FILES['locations'] : "";

				if ($files!='') {
				
					foreach ($files['tmp_name'] as $key => $tmp_name) {
						$_FILES[$key] = array(
							"name" => $files['name'][$key],
							"type" => $files['type'][$key],
							"tmp_name" => $files['tmp_name'][$key],
							"error" => $files['error'][$key],
							"size" => $files['size'][$key]
						);

						$upload = Image::upload($key, "public/uploads/imagewithmarkers");
								
						if($upload['status']){
							$locations['image'] = "uploads/locations/".$upload['img_name'];
						}
					}
					
				}

				if ($Imagewithmarkers->updataLocataion($locations, $locationId)) {
					Alert::set("success", "Successfully saved");
				}
				else {
					Alert::set("error", "Error saving");
				}

				Router::go("admin/imagewithmarkers");
			}
		}
	
		public function changeimageAction()
		{
			$Imageformarker = new Model_Imageformarker();
			$this->view->imageformarker = $Imageformarker->get();

			if (!empty($_FILES)) {
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

				if (count($this->view->imageformarker)) {
					db::update("imageformarkers", $elements, "id=".(int)$this->view->imageformarker[0]['id'] );
					Router::go("admin/imagewithmarkers");					
				}
				else {
					DB::insert("imageformarkers", $elements);
					Router::go("admin/imagewithmarkers");
				}
			}
		}
		public function seoAction(){
			$SEO = new Model_SEO();
			$this->view->seo = $SEO->getAll();

			if ( Router::$params[0] == "add" ) {
				DB::insert( "page_meta", array(
					"title" => 'New Page',
					"uri" => '-new-address'
					) );
				Router::go( "admin/seo");
			}
			else if ( Router::$params[0] == "delete" ) {
				$id = Router::$params[1];
				DB::delete( "page_meta", array('id'=>$id) );
				Router::go( "admin/seo");
			}
			else if ( Router::$params[0] == "edit" ) {
				$id = Router::$params[1];
				$this->view->seo = $SEO->find($id);

				$this->setView('admin/seo_edit.php');

			}
			else if ( Router::$params[0] == "update" ) {
				if ( !empty($_POST) ) {
					$id = Router::$params[1];
					$this->view->seo = $SEO->find($id);

					if (!empty($_POST['delete_image']) && $_POST['delete_image'] == 1 && !empty($this->view->seo['image'])) {

						$delete = unlink('public/'.$this->view->seo['image']);
						$_POST['image'] = "";
						unset($_POST['delete_image']);
					}
					else {
						unset($_POST['delete_image']);
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

					if ($SEO->update($elements, $id)) {
						Alert::set("success","Successfully saved");
					}
					else {
						Alert::set("error","Error saving");
					}

					Router::go("admin/seo/edit/".$id);

				}
				else {
					Router::go("admin/seo/edit/".$id);
				}
			}
		}		
	}
?>
