<?php
//pointer to the license file
include "../license.php";

class Tab {
	private $idPointer;
	private $id;
	private $title;
	private $content;
	private $dbAccess;

	public function Tab(DBAccess $dbAccess) {
		//DBAccess needs to be instantiated outside of this class. $dbAccess is just a reference, not a copy, simply to reduce memory usage.
		$this->dbAccess = $dbAccess;
		$this->dbAccess->connect();

		$SQL = "SELECT * FROM tab ORDER BY title ASC";
		$query = mysql_query($SQL);
		if (!$query) {
			echo(mysql_error());
			exit();
		}
		$i=0;
		while ($result = mysql_fetch_array($query)) {
			$this->idPointer[$i] = $result['id'];
			$this->id[$result['id']] = $result['id'];
			$this->title[$result['id']] = $result['title'];
			$this->content[$result['id']] = $result['content'];
			$i++;
		}
	}

	/**
	 * ACCESSOR:
	 * private $id;
	 * private $idPointer;
	 * private $title;
	 * private $content;
	 */

	public function getID($i) {
		return $this->id[$i];
	}

	public function getIDPointer($i) {
		return $this->idPointer[$i];
	}

	public function getTitle($i) {
		return $this->title[$i];
	}

	public function getContent($i) {
		return $this->content[$i];
	}
}

?>
