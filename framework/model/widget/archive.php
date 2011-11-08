<?php
//pointer to the license file
include "../../license.php";

class Archive {
	private $archive;
	private $year;
	private $month;
	private $dbAccess;

	public function Archive(DBAccess $dbAccess) {
		$this->dbAccess = $dbAccess;
		$this->dbAccess->connect();

		$SQL = "SELECT DISTINCT date_gmt FROM content ORDER BY date_gmt DESC";
		$query = mysql_query($SQL);
		if (!$query) {
			die("Database ERROR! Can't get archive!");
		}
		
		$i=0;
		while($result = mysql_fetch_array($query)) {
			$temp = explode("-", $result['date_gmt']);
			$temp[2] = $temp[0]."-".$temp[1];
			if ($i==0 || $temp[2]!=$this->archive[$i-1]) {
				$this->archive[$i] = $temp[2];
				$this->year[$i] = $temp[0];
				switch($temp[1]) {
					case "01": $this->month[$i] = "January"; break;
					case "02": $this->month[$i] = "February"; break;
					case "03": $this->month[$i] = "March"; break;
					case "04": $this->month[$i] = "April"; break;
					case "05": $this->month[$i] = "May"; break;
					case "06": $this->month[$i] = "June"; break;
					case "07": $this->month[$i] = "July"; break;
					case "08": $this->month[$i] = "August"; break;
					case "09": $this->month[$i] = "September"; break;
					case "10": $this->month[$i] = "October"; break;
					case "11": $this->month[$i] = "November"; break;
					case "12": $this->month[$i] = "December"; break;
				}
				$i++;
			}
		}
	}
	
	public function getArchive($i) {
		return $this->archive[$i];
	}

	public function getYear($i) {
		return $this->year[$i];
	}

	public function getMonth($i) {
		return $this->month[$i];
	}
}

?>
