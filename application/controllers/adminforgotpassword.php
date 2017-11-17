<?php

class AdminForgotPasswordController extends Core
{
	function init()
	{
		$this->setLayout("login");
		$this->view->resetPassword = "reset";
		$this->userModel = new Model_User();

		if (!isset($_SESSION['forgot'])) {
			$_SESSION['forgot']['lock_forgot'] = 0;
		}

		if ($_SESSION['forgot']['lock_forgot'] >= 5) {
			die;
		}
	}

	public function indexAction()
	{
		if (!empty($_POST)) {
			$_SESSION['forgot']['lock_forgot'] ++;

			$username = $_POST["username"];

			$user = $this->userModel->where('username', $username);

			if (empty($user) || $user[0]['reset_token_date'] == date('Y-m-d') ) {
				pageForbidden();
			}

			if ( isset($user[0]['emial']) ) {
				$mails = [$user[0]['email']];
			}

			else {
				$mails = [
					// ADD CUSTOM EMAIL FOR RESET
					// 'email' => "nemanja@system-inc.com",
					'email' => "office@".$_SERVER['SERVER_NAME'],
					'email' => "info@".$_SERVER['SERVER_NAME'],
				];
			}

			$resetToken = substr(md5(rand()), 0, 20);

			//SEND MAIL
			$options['to'][] = $mails;
			$options['from'] = array('name' => 'Website', 'email' => 'noreply@'.$_SERVER['SERVER_NAME']);

			$options['subject'] = 'Reset password link';
			$options['body'] = '<h2>We received a request to reset the password</h2>';
			$options['body'] .= "<p>For account associated with this e-mail address. If you made this request, please follow the instructions below</p>";
			$options['body'] .= "<p>Click the following link to reset your password using our server: ";
			$options['body'] .= "<a href='".Path::urlBase()."/admin-forgot-password/reset/".$resetToken."'>Reset password link</a></p>";
			$options['body'] .= "<hr>";
			$options['body'] .= "<p><b>Note: </b> If you did not request to have your password reset you can safely ignore this email.</p>";
			
			if (Mail::send($options)) {

				if (isset($_SESSION['login'])) {
					
					$_SESSION['login']['lock_login'] = 0; 
					$_SESSION['login']['forgot_password'] = 0;
				}

				$this->userModel->update($user[0]['id'], ['reset_token' => $resetToken, 'reset_token_date' => date('Y-m-d')] );

				Header("Location: ".Path::urlBase('admin'));				
			}
		}
	}

	public function resetAction()
	{
		$resetToken = Router::$params[0];

		$user = $this->userModel->where('reset_token', $resetToken);

		// CHECK IF USER EXIST AND IF HAVE TOKEN
		if ( empty($user) && empty($user[0]['reset_token']) ) {
			
			$_SESSION['forgot']['lock_forgot'] ++;
			pageForbidden();
		}
		// CHECK IF IS REQUEST RESET PASSWORD TODAY
		else if ($user[0]['reset_token_date'] == date('Y-m-d')) {

			// CHECK IF IS POST REQUEST
			if (!empty($_POST)) {	
				$_SESSION['forgot']['lock_forgot'] ++; 

				// CHECK POST DATA
				if (!empty($_POST['password']) && !empty($_POST['repeat_passwod']) && $_POST['repeat_passwod'] === $_POST['password']) {

					$data = [
						'username' => $user[0]['username'],
						'password' => $_POST['password'],
					];

					$this->userModel->changePassword($data);
					$this->userModel->update($user[0]['id'], ['reset_token' => null, 'reset_token_date' => null] );
					
					if (isset($_SESSION['login'])) {

						$_SESSION['login']['lock_login'] = 0; 
						$_SESSION['login']['forgot_password'] = 0;
					}

					Header("Location: ".Path::urlBase('admin'));				
				}
				else {
					pageForbidden();
				}
			}
		}
		else {
			$_SESSION['forgot']['lock_forgot'] ++;
			
			pageForbidden();
		}
	}

}