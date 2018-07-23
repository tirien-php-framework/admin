<?php
	require_once("application/controllers/admin.php");

	class AdminteamController extends AdminController
	{

		function init(){

			$this->setLayout("admin");
			$this->Team = new Model_Team();

		}

		public function indexAction(){

			$this->view->team = $this->Team->getOrdered();	

		}

		public function editAction(){

			if (!empty(Router::$params[0])){
            	$id = Router::$params[0];
				$this->view->team = $this->Team->find($id);				
			}

		}

		public function createAction(){
			//
		}

		public function removeAction(){

			if (!empty(Router::$params[0])){

            	$id = Router::$params[0];

				DB::update("teams", "status=0", "id=".$id );
			}

			Alert::set("success", "Team removed");
			Router::go('admin-team');
		}

		public function saveAction(){
			if (empty($_POST)) {
				Router::go('admin-team');
			}

			if (empty($_POST['title'])) {
				Alert::set("error", "Title are required");
				Router::go('admin-team/create');
			} else {
				$_POST['created_at'] = date("Y-m-d H:i:s");
				
				db::insert("teams", $_POST);
				Alert::set("success", "Team created");
				Router::go('admin-team');
			}
		}

		public function updateAction()
		{
			if (!empty(Router::$params[0])) {

            	$id = Router::$params[0];
				$this->view->team = $this->Team->find($id);

				if (!empty($this->view->team['id'])) {
					if (empty($_POST['title'])) {
						Alert::set("error", "Title are required");
						Router::go('admin-team/edit/'.$id);
					} else{
						db::update("teams", $_POST, "id=".(int)$id );
						Alert::set("success", "Team updated");
						Router::go('admin-team/edit/'.$id);
					}
				} else {
					Alert::set("error", "Team not found!");
					Router::go('admin-team');
				}
			} else {
				Alert::set("error", "Page not found!");
				Router::go('admin-team');
			}
		}

		public function saveorderAction(){

			$this->disableView();
			$order = $_POST['order'];				
			foreach ($order as $order_number => $id) {
				$this->Team->update($id, ['order_number' => (int)$order_number]);
			}

			echo "Success";

		}

		public function sanitizeSlug($slug)
	    {
	        return trim(strtolower(preg_replace(['/[^a-zA-Z0-9\/]/', '/\/+/', '/-+/'], ['-', '/', '-'], $slug)), '-');
	    }

	}