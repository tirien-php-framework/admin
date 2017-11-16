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

			if (empty($user) && empty($user[0]['reset_token'])) {
				pageForbidden();
			}

			if ( isset($user[0]['emial']) ) {
				$mails = [$user[0]['email']];
			}
			else {
				$mails = [
					'email' => "nemanja@system-inc.com",
					'email' => "office@".$_SERVER['SERVER_NAME'],
					'email' => "info@".$_SERVER['SERVER_NAME'],
				];
			}

			$resetToken = substr(md5(rand()), 0, 20);

			//SEND MAIL
			$options['to'][] = $mails;
			$options['from'] = array('name' => 'Website', 'email' => 'noreply@'.$_SERVER['SERVER_NAME']);

			$options['subject'] = 'Reset password link';
			$options['body'] = '<h2>You just submited, a reset password request</h2>';
			$options['body'] .= "<p><b>Note: </b> if you not submited password reset request, please don't do nothing and keep this email. If you forgot you password in feature use link bellow to reset.</p>";
			$options['body'] .= "<hr>";
			$options['body'] .= "<p>To reset password click on link bellow.</p>";
			$options['body'] .= "<a href='".Path::urlBase()."/admin-forgot-password/reset/".$resetToken."'>Reset password link</a>";
			
			if (Mail::send($options)) {
				if (isset($_SESSION['login'])) {
					$_SESSION['login']['lock_login'] = 0; 
					$_SESSION['login']['forgot_password'] = 0;
				}

				$this->userModel->update($user[0]['id'], ['reset_token' => $resetToken] );

				Header("Location: ".Path::urlBase('admin'));				
			}
		}
	}

	public function resetAction()
	{
		$resetToken = Router::$params[0];

		$user = $this->userModel->where('reset_token', $resetToken);

		if ( empty($user) ) {
			$_SESSION['forgot']['lock_forgot'] ++;
			pageForbidden();
		}

		if (!empty($_POST)) {	
			$_SESSION['forgot']['lock_forgot'] ++; 
			if (!empty($_POST['password']) && !empty($_POST['repeat_passwod']) && $_POST['repeat_passwod'] === $_POST['password']) {

				$data = [
					'username' => $user[0]['username'],
					'password' => $_POST['password'],
				];

				$this->userModel->changePassword($data);
				$this->userModel->update($user[0]['id'], ['reset_token' => null] );
				
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

}