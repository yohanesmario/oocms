<?php
//pointer to the license file
include "../license.php";

class Session {
	private $usernameblog;
	private $emailblog;
	private $websiteblog;

	public function startSession() {
		session_start();
		$this->usernameblog = $_SESSION['usernameblog'];
		$this->emailblog = $_SESSION['emailblog'];
		$this->websiteblog = $_SESSION['websiteblog'];
	}
}

?>
