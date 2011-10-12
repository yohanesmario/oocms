<?php

class DBAccess {
	private $usr = "";
	private $pwd = "";
	private $host = "localhost";
	private $db = "";

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
