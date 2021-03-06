<?php
//pointer to the license file
include "../license.php";

class Article {
	private $id;
	private $gmtTime;
	private $gmtDate;
	private $time;
	private $date;
	private $title;
	private $content;
	private $folder;
	private $author;
	private $articleNum;
	private $dbAccess;

	public function Article(DBAccess $dbAccess, $id, $folder, $archive) {
		//DBAccess needs to be instantiated outside of this class. $dbAccess is just a reference, not a copy, simply to reduce memory usage.
		$this->dbAccess = $dbAccess;
		$this->dbAccess->connect();

		if ($id!=NULL) {
			$SQL = "SELECT * FROM content WHERE id = $id ORDER BY date_gmt DESC, time_gmt DESC";
		} else if ($folder!=NULL) {
			$SQL = "SELECT * FROM content WHERE folder = '$folder' ORDER BY date_gmt DESC, time_gmt DESC";
		} else if ($archive!=NULL) {
			$SQL = "SELECT * FROM content WHERE date_gmt LIKE '$archive%' ORDER BY date_gmt DESC, time_gmt DESC";
		} else {
			$SQL = "SELECT * FROM content ORDER BY date_gmt DESC, time_gmt DESC";
		}
		$query = mysql_query($SQL);
		if (!$query) {
			echo(mysql_error());
			exit();
		}
		$time_zone = (!$_COOKIE['timezone_js'])?"GMT":$_COOKIE['timezone_js'];
		$i=0;
		while ($result = mysql_fetch_array($query)) {
			$this->id[$i] = $result['id'];
			$this->gmtTime[$i] = $result['time_gmt'];
			$this->gmtDate[$i] = $result['date_gmt'];
			$time = explode(":", $this->gmtTime[$i]);
			$date = explode("-", $this->gmtDate[$i]);

			date_default_timezone_set("GMT");
			$mktime_gmt = mktime(intval($time[0]), intval($time[1]), intval($time[2]), intval($date[1]), intval($date[2]), intval($date[0]));
			date_default_timezone_set($time_zone);
			$mktime_user = mktime(intval($time[0]), intval($time[1]), intval($time[2]), intval($date[1]), intval($date[2]), intval($date[0]));
			$mktime = $mktime_gmt-$mktime_user;

			$mktime = mktime(intval($time[0]), intval($time[1]), intval($time[2]), intval($date[1]), intval($date[2]), intval($date[0]))+$mktime;
			$this->date[$i] = date("l, d F Y", $mktime); //Friday, 19 August 2011
			$this->time[$i] = date("g:i A", $mktime); //2:16 PM
			$this->time[$i] .= ($time_zone=="GMT")?" GMT":""; //2:16 PM GMT
			$this->title[$i] = $result['title'];
			$this->content[$i] = $result['content'];
			$this->folder[$i] = $result['folder'];
			$this->author[$i] = $result['content_author'];
			$i++;
		}
		$this->articleNum = $i;
	}

	public function getLimit() {
		$SQL = "SELECT * from options WHERE id=1";
		$query = mysql_query($SQL);
		if (!$query) {
			die("Database ERROR! Can't get content limit!");
		}

		$result = mysql_fetch_array($query);
		$limit = $result['limits'];
		return $limit;
	}

	public function countComments($id) {
		$SQL = "SELECT * from comments WHERE post_id = $id AND approval = 'approved' ORDER BY comment_date ASC, comment_time ASC";
		$query = mysql_query($SQL);
		if (!$query) {
			die("Database ERROR! Can't get comments!");
		}

		$i=0;
		while ($result = mysql_fetch_array($query)) {
			$i++;
		}
		return $i;
	}

	public function commentDB($id, $reply) {
		$SQL = "SELECT * from comments WHERE post_id = $id AND approval = 'approved' AND reply_to = $reply ORDER BY comment_date ASC, comment_time ASC";
		$query = mysql_query($SQL);
		if (!$query) {
			die("Database ERROR! Can't get comments!");
		}
		$i=0;
		while ($result[$i]=mysql_fetch_array($query)) {
			$time = explode(":", $result[$i]['comment_time']);
			$date = explode("-", $result[$i]['comment_date']);

			date_default_timezone_set("GMT");
			$mktime_gmt = mktime(intval($time[0]), intval($time[1]), intval($time[2]), intval($date[1]), intval($date[2]), intval($date[0]));
			date_default_timezone_set($time_zone);
			$mktime_user = mktime(intval($time[0]), intval($time[1]), intval($time[2]), intval($date[1]), intval($date[2]), intval($date[0]));
			$mktime = $mktime_gmt-$mktime_user;

			$mktime = mktime(intval($time[0]), intval($time[1]), intval($time[2]), intval($date[1]), intval($date[2]), intval($date[0]))+$mktime;
			$result[$i]['comment_date'] = date("l, d F Y", $mktime); //Friday, 19 August 2011
			$result[$i]['comment_time'] = date("g:i A", $mktime); //2:16 PM
			$result[$i]['comment_time'] .= ($time_zone=="GMT")?" GMT":""; //2:16 PM GMT
			$i++;
		}
		return $result;
	}

	/**
	 * ACCESSOR:
	 * private $id;
	 * private $gmtTime;
	 * private $gmtDate;
	 * private $title;
	 * private $content;
	 * private $folder;
	 * private $author;
	 * private $articleNum;
	 */

	public function getID($i) {
		return $this->id[$i];
	}

	public function getGMTTime($i) {
		return $this->gmtTime[$i];
	}

	public function getGMTDate($i) {
		return $this->gmtDate[$i];
	}

	public function getTime($i) {
		return $this->time[$i];
	}

	public function getDate($i) {
		return $this->date[$i];
	}

	public function getTitle($i) {
		return $this->title[$i];
	}

	public function getContent($i) {
		return $this->content[$i];
	}

	public function getFolder($i) {
		return $this->folder[$i];
	}

	public function getAuthor($i) {
		return $this->author[$i];
	}

	public function getArticleNum() {
		return $this->articleNum;
	}
}

?>
