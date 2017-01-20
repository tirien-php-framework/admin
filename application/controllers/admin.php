<?php 
	define("ELEMENT_TYPE_TEXTLINE", 1);
	define("ELEMENT_TYPE_TEXTAREA", 2);
	define("ELEMENT_TYPE_IMAGE", 	3);
	define("ELEMENT_TYPE_GALLERY", 	4);
	define("ELEMENT_TYPE_LINK", 	5);
	define("ELEMENT_TYPE_HTML", 	6);

	class AdminController extends Core
	{

		// must be final constructor, because init() can be overwritten
		final function __construct(){
			parent::__construct();

			if(!Auth::check() && Router::$action != "login") {
				Auth::loginPage();
			}
			
			$this->setLayout('admin');
		
		}

		function loginAction(){
			$this->setLayout("login");

			// $u = new Model_User();
			// $new_user = $u->createUser($_POST);

			if (!empty($_POST['username']) && isset($_POST['password']) && Auth::login( $_POST['username'], $_POST['password'])) { 
				Header("Location: ".Path::urlBase('admin'));
				
				die();
			} else {
				$this->view->error = "bad login";
			}
		}

		function logoutAction(){
			Auth::logout();
			Header("Location: ".Path::urlBase('admin'));
			die();
		}

		public function indexAction(){
			//
		}

		public function eventsAction(){
			$event = new Model_Event();

			if ( Router::$params[0] == "edit" ) {
				$this->view->event = $event->find( Router::$params[1] );
				
				$this->setView("admin/event_edit.php");
			
			} elseif (Router::$params[0] == "update") {
				if (empty($_POST['title'])) {
					Alert::set('error', "Title is required");

					Router::go("admin/events/edit/".Router::$params[1]);
				} else {
					$event->update(Router::$params[1], $_POST);

					Router::go("admin/events");
				}
			
			} elseif (Router::$params[0] == "delete") {
				$event->delete(Router::$params[1]);

				Router::go("admin/events");

			} elseif (Router::$params[0] == "save") {

				if (empty($_POST['title'])) {
					Alert::set('error', "Title is required");

					Router::go("admin/events/create");
				} else {
					
					$event->create($_POST);
					
					Router::go("admin/events");
				}

			} elseif (Router::$params[0] == "create") {
				$this->setView("admin/event_create.php");
			
			} else {
				$this->view->events = $event->get();
			}
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

							if ($_FILES[$key]['type'] == "image/svg+xml") {
								$svg = File::upload($key, 'public/uploads/images');		
								foreach ($svg as $value) {
						    		$elements[$key] = $value;
								}
							} else if ($temp !='pdf') {
								$upload = Image::upload($key, "public/uploads/images");
								
								if($upload['status']){
									$elements[$key] = $upload['uri'];
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
				vd(ml::p());

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
				"file" => 'application/databases/leaddb.db'
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

		public function exportAction()
		{
			// SET LEAD TABLE
			$this->setLeadTable();

			$this->disableLayout();
			$this->disableView();

			$lead_type = (int)Router::$params[0];

			if( !empty(Router::$params[0]) ){
				$data = DB::query( "SELECT data FROM lead WHERE status=1 AND lead_type_id=?", $lead_type );
			}
			else{
				$data = DB::query("SELECT data FROM lead WHERE status=1");
			}


			if( !empty($data) ){
				$columns = array();

				foreach($data as &$row){ 
					$row = json_decode($row['data'], 1);
					if( empty($columns) ){
						foreach ($row as $key => $value) {
							$columns[] = $key;
						}
					}
				}
							
				Export::toXLS($data, $columns);
			}

		}		
	}
?>