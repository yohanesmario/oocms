<?php
//pointer to the license file
include "../../license.php";

class Title {
	private $title;
	private $tagline;
	private $dbAccess;

	public function Title($dbAccess) {
		$this->dbAccess = $dbAccess;
		$this->dbAccess->connect();

		$SQL = "SELECT * FROM options where id = 1";
		$query = mysql_query($SQL);
		if (!$query) {
			die("ERROR! Can't get title!");
		}
		$result = mysql_fetch_array($query);
		$this->title = $result['blog_title'];
		$this->tagline = $result['tag_line'];
	}

	public function getTitle() {
		return $this->title;
	}

	public function getTagline() {
		return $this->tagline;
	}
}

?>
