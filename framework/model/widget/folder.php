<?php

class Folder {
	private $folder;
	private $dbAccess;

	public function Folder(DBAccess $dbAccess) {
		$this->dbAccess = $dbAccess;
		$this->dbAccess->connect();

		$SQL = "SELECT DISTINCT folder FROM content ORDER BY folder ASC";
		$query = mysql_query($SQL);
		if (!$query) {
			die("Database ERROR! Can't get folders!");
		}
		
		$i=0;
		while($result=mysql_fetch_array($query)) {
			$this->folder[$i] = $result['folder'];
			$i++;
		}
	}
	
	public function getFolder($i) {
		return $this->folder[$i];
	}
}

?>
