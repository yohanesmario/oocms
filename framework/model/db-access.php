<?php
//pointer to the license file
include "../license.php";

class DBAccess {
	private $usr = ""; //enter your database username
	private $pwd = ""; //enter your database password
	private $host = "localhost"; //enter your database host (default: localhost)
	private $db = ""; //enter your database name

	public function connect() {
		$cid = mysql_connect($this->host, $this->usr, $this->pwd);
		mysql_select_db($this->db);
		if (!$cid) {
			echo("ERROR: " . mysql_error());
			exit();
		}
	}
}

?>
