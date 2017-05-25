<?php 
/**
 * Submit to leads/submit/subscribe or leads/submit/contact
 */

	class LeadsController extends Core
	{
		public $msg_thankyou = "Thank you for submitting";
		public $msg_error = "Submit failed";

		const LEAD_TYPE_CONTACT = 1;
		const LEAD_TYPE_SUBSCRIPTION = 2;

		function init()
		{			
			DB::init(array(
				"type" => 'sqlite',
				"file" => 'application/databases/leads.db'
			));
		}

		function submitAction()
		{
			$this->setLayout("default");
			$action = Router::$params[0];

			if( !empty($_POST['submit']) ){
				unset($_POST['submit']);
			}

			if( $action == "subscribe" ){
				if( !empty($_POST['email']) && filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ){
					$insert_data = array(
						'data' => json_encode($_POST),
						'lead_type_id' => LEAD_TYPE_SUBSCRIPTION,
						'dti' => date("Y-m-d H:i:s")
						);

					$insert = DB::insert( "lead", $insert_data );
				}
			}
			else if( $action == "contact" ){
				if( 
					!empty($_POST['name']) && 
					!empty($_POST['phone']) && 
					!empty($_POST['email']) && 
					filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) 
					){

					$insert_data = array(
						'data' => json_encode($_POST),
						'lead_type_id' => LEAD_TYPE_CONTACT,
						'dti' => date("Y-m-d H:i:s")
						);

					$insert = DB::insert( "lead", $insert_data );
				}
				else{
					return $this->ajax ? $this->msg_error : Router::back();
				}
			}
			else{
				return $this->ajax ? $this->msg_error : Router::back();
			}

			if( !empty($insert) ){
				//PREPARE MAIL
				$headers = "MIME-Version: 1.0\r\n";	
				$headers .= "Content-type: text/html; charset=utf-8\r\n";
				$headers .= "From: Website Mailer <noreply@website.com>\r\n";

				$to = 'mladen@tirien.com';
				$subject = 'Lead from Website';

				$body = "<html><body>";

				foreach ($_POST as $key => $value) {
					$body .= "<b>" . str_replace("_", " ", ucfirst($key)) . ":</b> " . (!empty($value) ? $value : '/') . "<br>";
				}

				$body .= "</body></html>";

				//SEND MAIL
				mail($to, $subject, $body, $headers);

				return $this->ajax ? $this->msg_thankyou : Router::go('leads/thank-you');				
			}
			else{
				return $this->ajax ? $this->msg_error : Router::back();				
			}
		}

		function thankYouAction()
		{
			$this->view->head['title'] = "Thank You";
		}	
	}
?>