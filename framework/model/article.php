<?php

class Article {
	private $id;
	private $gmtTime;
	private $gmtDate;
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
			$SQL = "SELECT * FROM content WHERE article_date LIKE '$archive%' ORDER BY date_gmt DESC, time_gmt DESC";
		} else {
			$SQL = "SELECT * FROM content ORDER BY date_gmt DESC, time_gmt DESC";
		}
		$query = mysql_query($SQL);
		if (!$query) {
			echo(mysql_error());
			exit();
		}
		$i=0;
		while ($result = mysql_fetch_array($query)) {
			$this->id[$i] = $result['id'];
			$this->gmtTime[$i] = $result['time_gmt'];
			$this->gmtDate[$i] = $result['date_gmt'];
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
