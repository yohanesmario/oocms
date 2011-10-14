<?php

class Blogroll {
	private $blog;
	private $name;
	private $dbAccess;

	public function Blogroll(DBAccess $dbAccess) {
		$this->dbAccess = $dbAccess;
		$this->dbAccess->connect();

		$SQL = "SELECT * FROM blogroll ORDER BY user_name ASC";
		$query = mysql_query($SQL);
		if (!$query) {
			die("Database ERROR! Can't get blogroll!");
		}
		
		$i=0;
		while($result=mysql_fetch_array($query)) {
			$this->name[$i] = $result['user_name'];
			$this->blog[$i] = $result['blog'];
			$i++;
		}
	}
	
	public function getName($i) {
		return $this->name[$i];
	}

	public function getBlog($i) {
		return $this->blog[$i];
	}
}

?>
