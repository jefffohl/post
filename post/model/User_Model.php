<?php


class User_Model extends PostDatabase {

	private $passwordProxy = "*****";
	
	public function login($username,$password) {
			$params = array();
			$params['username'] = $username;
			//$params['password'] = $password;
			$query = "SELECT * FROM users WHERE username=:username";
			$statement = $this->dbHandle->prepare($query);
			$statement->execute($params);
			if (1 !== $statement->rowCount()) {
				return false;
			}
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$result = $statement->fetch();
			if ($this->checkPassword($password, $result['password'])) {
				$this->updateSession($result);
				return true;	
			} else {
				return false;
			}

	}
	
	public function getUsers($page) {
		return $this->pagedQuery($page,10,'users','id','asc','firstname,lastname,username,email,class,id');
	}
	
	public function delete($userID) {
		$params = array();
		$params['userid'] = (int)$userID;
		$query = "DELETE FROM users WHERE id=:userid";
		$statement = $this->dbHandle->prepare($query);
		$statement->execute($params);
	}
	
	public function updateSession($user) {
		$_SESSION['firstname'] = $user['firstname'];
		$_SESSION['lastname'] = $user['lastname'];
		$_SESSION['username'] = $user['username'];
		$_SESSION['class'] = $user['class'];
		$_SESSION['id'] = $user['id'];
	}

	public function encryptPassword($password) {
		return password_hash($password, PASSWORD_DEFAULT);
	}

	public function checkPassword($password, $hash) {
		return password_verify($password, $hash);
	}
	
	public function createAccount($firstname,$lastname,$username,$email,$password,$commentsNotification) {
		$params = array();
		$params['username'] = $username;
		
		/* check to see if there is already a user with that username */
		$checkQuery = "SELECT * FROM users WHERE username=:username";
		$checkStatement = $this->dbHandle->prepare($checkQuery);
		$checkStatement->execute($params);
		if ($checkStatement->rowCount() > 0) {
			return "Sorry. Someone already took that username.";
		}
		// reset params
		$params = array();
		$params['firstname'] = $firstname;
		$params['lastname'] = $lastname;
		$params['username'] = $username;
		$params['email'] = $email;
		$params['password'] = $this->encryptPassword($password);
		$params['commentsNotification'] = $commentsNotification;
		$params['class'] = 'User';
		$query = "INSERT INTO users (firstname,lastname,username,email,password,commentsNotification,class) VALUES (:firstname,:lastname,:username,:email,:password,:commentsNotification,:class)";
		
		/* check connection */
		
		$statement = $this->dbHandle->prepare($query);
		$statement->execute($params);
		
		/* update the session to reflect any changed data */
		$params = array();
		$params['username'] = $username;
		$query = "SELECT * FROM users WHERE username=:username";
		$statement = $this->dbHandle->prepare($query);
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$result = $statement->fetch();
		if ($statement->rowCount() == 1) {
			$this->updateSession($result);
			$this->mailer($result);
			return true;
		}
		else {
			return "Some sort of problem occurred. Can you try again?";
		}
	}
	
	public function updateAccount($firstname,$lastname,$username,$email,$password,$commentsNotification,$id) {
		$params = array();
		$params['firstname'] = $firstname;
		$params['lastname'] = $lastname;
		$params['username'] = $username;
		$params['email'] = $email;
		if ($password !== $this->passwordProxy) {
			$params['password'] = $this->encryptPassword($password);
		}
		$params['commentsNotification'] = $commentsNotification;
		$params['id'] = $id;
		if ($password !== $this->passwordProxy) {
			$query = "UPDATE users SET firstname=:firstname, lastname=:lastname, username=:username, email=:email, password=:password,commentsNotification=:commentsNotification WHERE id=:id";
		} else {
			$query = "UPDATE users SET firstname=:firstname, lastname=:lastname, username=:username, email=:email, commentsNotification=:commentsNotification WHERE id=:id";
		}
		$statement = $this->dbHandle->prepare($query);
		$statement->execute($params);
		/* update the session to reflect any changed data */
		/* TODO: Make sure that all usernames are unique */
		$params = array();
		$params['username'] = $username;
		$query = "SELECT * FROM users WHERE username=:username";
		$statement = $this->dbHandle->prepare($query);
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$result = $statement->fetch();
		if ($statement->rowCount() == 1) {
			$result['password'] = $this->passwordProxy;
			$this->updateSession($result);
			return "Your account has been updated.";
		}
		else {
			return false;
		}
	}
	
	public function updateUser($firstname,$lastname,$email,$password,$commentsNotification,$id,$class) {
		$params = array();
		$params['firstname'] = $firstname;
		$params['lastname'] = $lastname;
		$params['email'] = $email;
		if ($password !== $this->passwordProxy) {
			$params['password'] = $this->encryptPassword($password);
		}
		$params['commentsNotification'] = $commentsNotification;
		$params['id'] = $id;
		$params['class'] = $class;
		if ($password !== $this->passwordProxy) {
			$query = "UPDATE users SET firstname=:firstname,lastname=:lastname,email=:email,password=:password,commentsNotification=:commentsNotification, class=:class WHERE id=:id";
		} else {
			$query = "UPDATE users SET firstname=:firstname,lastname=:lastname,email=:email,commentsNotification=:commentsNotification, class=:class WHERE id=:id";
		}

		$statement = $this->dbHandle->prepare($query);
		$statement->execute($params);
	}
	
	public function getUserAccount($userid) {
		$params = array();
		$params['userid'] = (int) $userid;
		$query = "SELECT * FROM users WHERE id=:userid";
		$statement = $this->dbHandle->prepare($query);
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$result = $statement->fetch();
		if (1 !== $statement->rowCount()) {
			return false;
		}
		$result['password'] = $this->passwordProxy;
		return $result;
	}
	
	public function getUserName($userid) {
		$params = array();
		$params['userid'] = (int) $userid;
		$query = "SELECT username FROM users WHERE id=:userid";
		$statement = $this->dbHandle->prepare($query);
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$result = $statement->fetch();
		if (1 !== $statement->rowCount()) {
				return false;
			}
		return $result['username'];
	}
	
	private function mailer($user) {
		// mail myself a notice 
		$message = "Someone registered on Post. Their name is {$user['firstname']} {$user['lastname']}. Their username is {$user['username']}. Their email address is {$user['email']}";

		// In case any of our lines are larger than 70 characters, we should use wordwrap()
		$message = wordwrap($message, 70);
		
		// Send
		mail(ADMIN_EMAIL, 'New User on Post', $message);
	}
	/*
	public function retrievePassword($username) {
		$params = array();
		$params['username'] = $username;
		$query = "SELECT password, email FROM users WHERE username=:username";
		$statement = $this->dbHandle->prepare($query);
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$result = $statement->fetch();
		if (1 !== $statement->rowCount()) {
				return false;
			}
		// email the password
$message = "Hello {$params['username']} -\n\nOn ".BLOG_TITLE.", you requested to have your password emailed to this address.\n\nYour password is: {$result['password']}\n
You may log in here: http://{$_SERVER['SERVER_NAME']}/?view=login\n
If you feel this was done in error, please contact the administrator at ".ADMIN_EMAIL.".\n\nCheers,\n\n".BLOG_TITLE." Team.";
		
		// Send
		mail($result['email'], 'Password retrieval from '.BLOG_TITLE, $message);
		return true;
	}
	*/
	
}

?>