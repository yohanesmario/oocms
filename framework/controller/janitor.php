<?php
//pointer to the license file
include "../license.php";

class Janitor {
	private $dbAccess;

	public function Janitor(DBAccess $dbAccess) {
		//DBAccess needs to be instantiated outside of this class. $dbAccess is just a reference, not a copy, simply to reduce memory usage.
		$this->dbAccess = $dbAccess;
		$this->dbAccess->connect();
	}

	public function sanitizeHTTPGet() {
		$result['id'] = ($this->validateID($_GET['id'])) ? $_GET['id'] : NULL;
		$result['folder'] = ($this->validateFolder($_GET['folder'])) ? $_GET['folder'] : NULL;
		$result['archive'] = ($this->validateArchive($_GET['archive'])) ? $_GET['archive'] : NULL;
		$result['page'] = ($this->validatePage($_GET['page'], $id, $folder, $archive)) ? $_GET['page'] : NULL;
		$result['tab'] = ($this->validateTab($_GET['tab'])) ? $_GET['tab'] : NULL;
		
		return $result;
	}

	public function validateNumbers($num) {
		$boolean = filter_var($num, FILTER_VALIDATE_INT);
		return $boolean;
	}

	public function validateEmail($email) {
		$boolean = filter_var($email, FILTER_VALIDATE_EMAIL);
		return $boolean;
	}

	public function validateURL($url) {
		$boolean = filter_var($url, FILTER_VALIDATE_URL);
		return $boolean;
	}

	public function sanitizeHTML($html) {
		$html = filter_var($html, FILTER_SANITIZE_SPECIAL_CHARS);
		return $html;
	}

	public function validateSession($username, $fullname, $email, $website, $type) {
		$SQL = "SELECT * FROM users ORDER BY id ASC";
		$query = mysql_query($SQL);
		if (!$query) {
			echo(mysql_error());
			exit();
		}
		$i=0;
		while ($result = mysql_fetch_array($query)) {
			$usr[$i] = $result['usernameblog'];
			$fname[$i] = $result['fullnameblog'];
			$mail[$i] = $result['emailblog'];
			$site[$i] = $result['websiteblog'];
			$typeblog[$i] = $result['typeblog'];
			$i++;
		}
		$i=0; $validator=false;
		while ($username[$i] && $validator==false) {
			if ($username==$usr[$i] && $fullname==$fname[$i] && $email==$mail[$i] && $website==$site[$i] && $type==$typeblog[$i]) {
				$validator=true;
			}
			$i++;
		}
		return $validator;
	}

	public function validateUserNamePassword($username, $password) {
		$password = ($password!=NULL)?hash("whirlpool", $password):NULL;

		$SQL = "SELECT * FROM users ORDER BY id ASC";
		$query = mysql_query($SQL);
		if (!$query) {
			echo(mysql_error());
			exit();
		}
		$i=0;
		while ($result = mysql_fetch_array($query)) {
			$usr[$i] = $result['usernameblog'];
			$fname[$i] = $result['fullnameblog'];
			$mail[$i] = $result['emailblog'];
			$site[$i] = $result['websiteblog'];
			$typeblog[$i] = $result['typeblog'];
			$pwd[$i] = $result['passwordblog'];
			$i++;
		}
		$i=0; $result['boolean'] = false;
		while ($pwd[$i] && $result['boolean']==false) {
			if ($password==$pwd[$i] && $username==$usr[$i]) {
				$result['boolean'] = true;
				$result['fullname'] = $fname[$i];
				$result['email'] = $mail[$i];
				$result['website'] = $site[$i];
				$result['type'] = $typeblog[$i];
			}
			$i++;
		}
		return $result;
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

	public function validateCommentID($num) {
		$SQL = "SELECT * FROM comments ORDER BY id ASC";
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

	public function processComment($sessionArray) {
		if ($_POST['comment']) {
			$loggedIn = $sessionArray['logged_in'];
			$comment = $this->sanitizeHTML($_POST['comment']);
			$name = ($loggedIn)?$sessionArray['fullname']:$_POST['name'];
			$email = ($loggedIn)?$sessionArray['email']:$_POST['email'];
			$website = ($loggedIn)?$sessionArray['website']:$_POST['website'];
			$date = gmdate("Y-m-d");
			$time = gmdate("H:i:s");
			$type = $sessionArray['type'];
			if (($website=="" || !$website || $this->validateURL($website)) &&
			     $this->validateEmail($email) &&
			     $this->validateID($_POST['id']) &&
			     ($this->validateCommentID($_POST['replyto']) || $_POST['replyto']=="0")) {
				$SQL = "INSERT INTO comments (commenter_name, email, website, comments, post_id, comment_date, comment_time, reply_to, commenter_type) VALUES ( '$name', '$email', '$website', '$comment', '".$_POST['id']."', '$date', '$time', '".$_POST['replyto']."', '$type');";
				$query = mysql_query($SQL);
				if (!$query) {
					echo(mysql_error());
					exit();
				}
				return "<script type='text/javascript'>document.getElementById('replytomessage').innerHTML='Comment is submitted!';</script>";
			} else {
				return "<script type='text/javascript'>document.getElementById('replytomessage').innerHTML='Please enter valid values!';</script>";
			}
			return "";
		}
	}

	public function processArticle($sessionArray) {
		if ($sessionArray['logged_in']==true) {
			if ($_POST['submitArticle']) {
				$title = $_POST['title'];
				$folder = $_POST['folder'];
				$id = ($_POST[id==NULL])?NULL:intval($_POST['id']);
				$content = $_POST['content'];
				$author = $sessionArray['fullname'];
				$date = gmdate("Y-m-d");
				$time = gmdate("H:i:s");
				if ($id==NULL) {
					$SQL = "INSERT INTO content (title, folder, date_gmt, time_gmt, content, content_author) VALUES ('$title', '$folder', '$date', '$time', '$content', '$author');";
				} else {
					$SQL = "UPDATE content SET title = '$title', folder = '$folder', content = '$content' WHERE id = $id";
				}
				$query = mysql_query($SQL);
				if (!$query) {
					echo(mysql_error());
					exit();
				}
			}
		}
	}

	public function processTab($sessionArray) {
		if ($sessionArray['logged_in']==true) {
			if ($_POST['submitTab']) {
				$title = $_POST['title'];
				$id = ($_POST[id==NULL])?NULL:intval($_POST['id']);
				$content = $_POST['content'];
				if ($id==NULL) {
					$SQL = "INSERT INTO tab (title, content) VALUES ('$title', '$content');";
				} else {
					$SQL = "UPDATE tab SET title = '$title', content = '$content' WHERE id = $id";
				}
				$query = mysql_query($SQL);
				if (!$query) {
					echo(mysql_error());
					exit();
				}
			}
		}
	}
}

?>
