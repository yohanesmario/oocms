<?php
//pointer to the license file
include "../../license.php";

class Tabs {
	private $id;
	private $title;
	private $dbAccess;

	public function Tabs(DBAccess $dbAccess) {
		$this->dbAccess = $dbAccess;
		$this->dbAccess->connect();

		$SQL = "SELECT * FROM tab ORDER BY title";
		$query = mysql_query($SQL);
		if (!$query) {
			die("ERROR! Can't get tab!");
		}
		$i = 0;
		while($result=mysql_fetch_array($query)) {
			$this->id[$i] = $result['id'];
			$this->title[$i] = $result['title'];
			$i++;
		}
	}

	public function getID($i) {
		return $this->id[$i];
	}

	public function getTitle($i) {
		return $this->title[$i];
	}
}

?>
