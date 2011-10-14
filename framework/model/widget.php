<?php

class Widget {
	private $id;
	private $type;
	private $content;
	private $dbAccess;

	public function Widget(DBAccess $dbAccess) {
		$this->dbAccess = $dbAccess;
		$this->dbAccess->connect();

		$SQL = "SELECT * from widget ORDER BY id ASC";
		$query = mysql_query($SQL);
		if (!$query) {
			die("Database ERROR! Can't get content widgets!");
		}

		$i=0;
		while($result = mysql_fetch_array($query)) {
			$this->id[$i] = $result['id'];
			$this->type[$i] = $result['widget_type'];
			$this->content[$i] = $result['content'];
			$i++;
		}
	}

	public function getID($i) {
		return $this->id[$i];
	}

	public function getType($i) {
		return $this->type[$i];
	}

	public function getContent($i) {
		return $this->content[$i];
	}

	public function setContent($i, $str) {
		if ($this->type[$i]!='text') {
			$this->content[$i] = $str;
		}
	}
}

?>
