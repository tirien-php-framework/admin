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
				//SEND MAIL
				$options['to'][] = array('email' => 'info@EXAMPLE.com');
				$options['from'] = array('name' => 'Website', 'email' => 'noreply@EXAMPLE.com');

				$options['subject'] = 'Lead from Website';
				$options['body'] = '';

				foreach ($_POST as $key => $value) {
					$options['body'] .= "<b>" . str_replace("_", " ", ucfirst($key)) . ":</b> " . (!empty($value) ? $value : '/') . "<br>";
				}
				
				if( Mail::send($options) ){
					$options['to'] = array();
					$options['to'][] = array('email' => filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL) );
					$options['from'] = array('name' => 'Website', 'email' => 'noreply@EXAMPLE.com');

					$options['subject'] = 'New lead';
					$options['body'] = 'Thank you for contacting us. Our representative will contact you soon.';

					Mail::send($options);
				}
				
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