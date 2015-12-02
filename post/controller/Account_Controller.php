<?php

require_once(MODEL_PATH.'User_Model.php');
require_once(CONTROLLER_PATH.'Validator.php');

class Account_Controller {
	
	public function __construct() {
		$this->userObj = new User_Model();
		$this->validator = new Validator();
		$this->title = "My Account";
	}
	//TODO: This needs to be cleaned up:
	public function execute() {
		if (!$this->isLoggedIn()) {
			return $this->logIn();
			/*
			if ($_GET['view'] == 'register') {
				return $this->register();
			}
			elseif ($_GET['view'] == 'forgotpassword' || $_GET['view'] == 'passwordretrieved') {
				return $this->forgotpassword();
			} else {
				return $this->logIn();
			}*/
		} else {
			if (isset($_GET['action'])) {
				switch ($_GET['action']) {
					case "logout" :
						return $this->logOut();
					case "login" :
						return $this->logIn();
					//case "register" :
					//	return $this->register();
					default :
						return $this->editAccount();
				}
			}
			return $this->editAccount();
		}
	}
	
	public function isLoggedIn() {
		return isset($_SESSION['username'])?true:false;
	}
	
	public function logIn() {
		global $smarty;
		// If no previous session, has the user submitted the form?
		if (isset($_POST['username'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			if($this->userObj->login($username,$password)) {
				header("Location: ".$_SERVER['PHP_SELF']);
			}
			else {
				$message = "Sorry. Please try again.";
				$smarty->assign('message',$message);
				$smarty->assign('messagetitle','Log In Failed');
				return $smarty->fetch('message.tpl');
			}
		}
		else {
			return $smarty->fetch('login.tpl');
		}
	}
	
	public function logOut() {
		session_start();
    	session_destroy();
		header("Location: ".$_SERVER['PHP_SELF']);
	}
	
	public function editAccount() {
		global $smarty;
		if (isset($_POST['id'])) {
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$commentsNotification = $_POST['commentsNotification'];
			$id = $_POST['id'];
			$user = $this->userObj->updateAccount($firstname,$lastname,$username,$email,$password,$commentsNotification,$id);
			if(!$user) {
				$message = "Some sort of problem occurred. There seems to be more than one user with that user name.";
				$smarty->assign('message',$message);
				$smarty->assign('messagetitle','Error');
				return $smarty->fetch('message.tpl');
			}
			/* cleanse the $_POST array */
			else {
			  header("Location: ".$_SERVER['PHP_SELF']);
			}
		}
		else {
			$user = $this->userObj->getUserAccount($_SESSION['id']);
			if (!$user) {
				$message = "Some sort of problem occurred. The record could not be obtained.";
				$smarty->assign('message',$message);
				$smarty->assign('messagetitle','Error');
				return $smarty->fetch('message.tpl');
			}
			else {
				$smarty->assign('user',$user);
			}
			if (isset($_GET['view']) && $_GET['view'] == 'editaccount') {
				return $smarty->fetch('edit_account.tpl');
			}
			else {
				return $smarty->fetch('view_account.tpl');
			}
		}
	}
	
	public function register() {
		global $smarty;
		if (isset($_POST['username'])) {
		    $firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$commentsNotification = $_POST['commentsNotification'];
			
			if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password)) {
				$smarty->assign('message','Sorry - you must fill in all the fields.');
				return $smarty->fetch('register.tpl');
			}
			
		
			if ($this->validator->validateEmail($_POST['email']) === false) {
				$smarty->assign('message','Sorry - that does not appear to be a valid email address.');
				return $smarty->fetch('register.tpl');
			}
			
			// filter the data
			
			$message = $this->userObj->createAccount($firstname,$lastname,$username,$email,$password,$commentsNotification);
			if($message === true) {
				header("Location: ".$_SERVER['PHP_SELF']);
			}
			else {
				$smarty->assign('message',$message);
				return $smarty->fetch('register.tpl');
			}
			
		// if not, we display the form for saving the data
		}
		else {
			return $smarty->fetch('register.tpl');
		}
	}
	/*
	public function forgotpassword() {
		global $smarty;
		if($_GET['view'] == "passwordretrieved") {
			$message = "Your password has been emailed to you. <a href='/account/'>Log in</a>.";
			$smarty->assign('message',$message);
			$smarty->assign('messagetitle','Thank You');
			return $smarty->fetch('message.tpl');
		}
		else {		
			if (isset($_POST['username'])) {
				$username = $_POST['username'];
				if($this->userObj->retrievePassword($username)) {
					header("Location: ".$_SERVER['PHP_SELF']."?view=passwordretrieved");
				}
				else {
					$smarty->assign("message","Sorry. We don't seem to have a record of that username. Can you try again?");
					return $smarty->fetch("forgotpassword.tpl");
				}
			}
			else {
					return $smarty->fetch('forgotpassword.tpl');
				}
		}
	}
	*/
}