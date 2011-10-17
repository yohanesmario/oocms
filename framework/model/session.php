<?php
//pointer to the license file
include "../license.php";

class Session {
	private $username;
	private $fullname;
	private $email;
	private $website;
	private $type;
	private $loggedIn;
	private $janitor;

	public function Session(Janitor $janitor) {
		session_start();
		$this->janitor = $janitor;
		$this->startSession();
	}

	private function startSession() {
		$boolean = $this->janitor->validateSession($_SESSION['username'],$_SESSION['fullname'],$_SESSION['email'],$_SESSION['website'],$_SESSION['type']);
		$this->username = ($boolean)?$_SESSION['username']:"guest";
		$this->fullname = ($boolean)?$_SESSION['fullname']:"Guest";
		$this->email = ($boolean)?$_SESSION['email']:NULL;
		$this->website = ($boolean)?$_SESSION['website']:NULL;
		$this->type = ($boolean)?$_SESSION['type']:"guest";
		$this->loggedIn = $boolean;
	}

	public function registerSession($username, $password) {
		$result = $this->janitor->validateUserNamePassword($username, $password);
		$boolean = $result['boolean'];
		$fullname = $result['fullname'];
		$email = $result['email'];
		$website = $result['website'];
		$type = $result['type'];
		$_SESSION['username'] = ($boolean)?$username:NULL;
		$_SESSION['fullname'] = ($boolean)?$fullname:NULL;
		$_SESSION['email'] = ($boolean)?$email:NULL;
		$_SESSION['website'] = ($boolean)?$website:NULL;
		$_SESSION['type'] = ($boolean)?$type:NULL;
		$this->startSession();
	}

	public function endSession() {
		session_destroy();
		session_start();
		$this->startSession();
	}

	public function getSessionArray() {
		$result['username'] = $this->username;
		$result['fullname'] = $this->fullname;
		$result['email'] = $this->email;
		$result['website'] = $this->website;
		$result['type'] = $this->type;
		$result['logged_in'] = $this->loggedIn;
		return $result;
	}
}

?>
