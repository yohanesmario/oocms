<?php
//pointer to the license file
include "../license.php";

class Janitor {
	private $dbAccess;

	public function Janitor(DBAccess$dbAccess) {
		//DBAccess needs to be instantiated outside of this class. $dbAccess is just a reference, not a copy, simply to reduce memory usage.
		$this->dbAccess = $dbAccess;
		$this->dbAccess->connect();
	}

	public function validateNumbers($num) {
		$boolean = filter_var($num, FILTER_VALIDATE_INT);
		return $boolean;
	}

	public function validateEmail($email) {
		$boolean = filter_var($email, FILTER_VALIDATE_EMAIL);
		return $boolean;
	}

	public function sanitizeHTML($html) {
		$html = filter_var($html, FILTER_SANITIZE_SPECIAL_CHARS);
		return $html;
	}

	public function validateID($num) {
		$SQL = "SELECT * FROM content ORDER BY id ASC";
		$query = mysql_query($SQL);
		if (!$query) {
			echo(mysql_error());
			exit();
		}
		$i=0;
		while ($result = mysql_fetch_array($query)) {
			$id[$i] = $result['id'];
			$i++;
		}
		$i=0; $validator=false;
		while ($id[$i] && $validator==false) {
			if ($num==$id[$i]) {
				$validator=true;
			}
			$i++;
		}
		return $validator;
	}

	public function validateTab($num) {
		$SQL = "SELECT * FROM tab ORDER BY id ASC";
		$query = mysql_query($SQL);
		if (!$query) {
			echo(mysql_error());
			exit();
		}
		$i=0;
		while ($result = mysql_fetch_array($query)) {
			$id[$i] = $result['id'];
			$i++;
		}
		$i=0; $validator=false;
		while ($id[$i] && $validator==false) {
			if ($num==$id[$i]) {
				$validator=true;
			}
			$i++;
		}
		return $validator;
	}

	public function validateFolder($str) {
		$SQL = "SELECT * FROM content ORDER BY id ASC";
		$query = mysql_query($SQL);
		if (!$query) {
			echo(mysql_error());
			exit();
		}
		$i=0;
		while ($result = mysql_fetch_array($query)) {
			$folder[$i] = $result['folder'];
			$i++;
		}
		$i=0; $validator=false;
		while ($folder[$i] && $validator==false) {
			if ($str==$folder[$i]) {
				$validator=true;
			}
			$i++;
		}
		return $validator;
	}

	public function validateArchive($str) {
		$SQL = "SELECT * FROM content ORDER BY id ASC";
		$query = mysql_query($SQL);
		if (!$query) {
			echo(mysql_error());
			exit();
		}
		$i=0;
		while ($result = mysql_fetch_array($query)) {
			$temp= explode("-",$result['date_gmt']);
			$archive[$i] = $temp[0]."-".$temp[1];
			$i++;
		}
		$i=0; $validator=false;
		while ($archive[$i] && $validator==false) {
			if ($str==$archive[$i]) {
				$validator=true;
			}
			$i++;
		}
		return $validator;
	}

	public function validatePage($num, $id, $folder, $archive) {
		if ($id!=NULL) {
			$SQL = "SELECT * FROM content WHERE id = '$id' ORDER BY id ASC";
		} else if ($folder!=NULL) {
			$SQL = "SELECT * FROM content WHERE folder = '$folder' ORDER BY id ASC";
		} else if ($archive!=NULL) {
			$SQL = "SELECT * FROM content WHERE date_gmt LIKE '$archive%' ORDER BY id ASC";
		} else {
			$SQL = "SELECT * FROM content ORDER BY id ASC";
		}
		$query = mysql_query($SQL);
		if (!$query) {
			echo(mysql_error());
			exit();
		}
		$i=0;
		while ($result = mysql_fetch_array($query)) {
			$id[$i] = $result['id'];
			$i++;
		}

		$SQL = "SELECT * from options WHERE id=1";
		$query = mysql_query($SQL);
		if (!$query) {
			die("Database ERROR! Can't get content limit!");
		}

		$result = mysql_fetch_array($query);
		$limit = $result['limits'];

		$page = (( $i - ($i%$limit) ) / $limit) + ((($i%$limit)==0)?0:1);

		if ($num>0 && $num<=$page) {
			$validator = true;
		} else {
			$validator = false;
		}

		return $validator;
	}
}

?>
