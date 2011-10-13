<?php

class Book {
	private $article;

	public function Book(DBAccess $dbAccess, $id, $folder, $archive) {
		$dbAccess->connect();
		$this->article = new Article($dbAccess, $id, $folder, $archive);
	}

	public function printArticle($limit, $page, $comment, $id) {
		// NEED TO IMPLEMENT CLIENT_TIME_ZONE!
		$page = ($page==NULL || $page<=0)?1:$page;
		$comment = ($comment==NULL)?false:$comment;
		$limit = ($limit==NULL)?$this->article->getLimit():$limit;
		$i = $limit*($page-1);
		$iteration = 0;

		$return = "<span class='book'>";
		while ($this->article->getID($i) && $iteration<$limit) {
			$return .= "<div class='article'>";
				$return .= "<div class='title'><a title='By : ".$this->article->getAuthor($i)."' href='index.php?id=".$this->article->getID($i)."'>".$this->article->getTitle($i)."</a></div>";
				$return .= "<span class='date'>".$this->article->getGMTDate($i)."</span>";
				$return .= "<span class='time'>".$this->article->getGMTTime($i)."</span>";
				$return .= "<div class='content'>".$this->article->getContent($i)."</div>";
				$return .= "<div class='footer'>";
					if ($comment==false) {
						$return .= "<span class='folder'>Posted in <a href='index.php?folder=".$this->article->getFolder($i)."'>".$this->article->getFolder($i)."</a></span>";

						if ($this->article->countComments($this->article->getID($i)) > 1) {
							$return .= "<span class='commentCount'><a href='index.php?id=".$this->article->getID($i)."#comments'>".$this->article->countComments($this->article->getID($i))." comments</a></span>";
						} else if ($this->article->countComments($this->article->getID($i)) > 0) {
							$return .= "<span class='commentCount'><a href='index.php?id=".$this->article->getID($i)."#comments'>".$this->article->countComments($this->article->getID($i))." comment</a></span>";
						} else {
							$return .= "<span class='commentCount'><a href='index.php?id=".$this->article->getID($i)."#comments'>Add a comment</a></span>";
						}

					} else {
						//Comment section
						if ($id!=NULL) {
							$return .= "<div class='comments'>";
								$return .= $this->getComments(true, $this->article->getID($i), NULL);
							$return .= "</div>";
						} else {
							$return .= "<div class='comments'>";
								$return .= $this->getComments(false, $this->article->getID($i), NULL);
							$return .= "</div>";
						}
					}
				$return .= "</div>"; //end of <div class='footer'>
			$return .= "</div>"; //end of <div class='article'>
			$i++; $iteration++;
		}
		$return .= "</span>"; //end of <span class='book'>
		return $return;
	}

	private function getComments($commentBox, $id, $reply) {
		$reply = ($reply==NULL)?0:$reply;
		$result = $this->article->commentDB($id, $reply);

		$i=0;
		$return="";
		while ($result[$i]) {
			$return .= "<div class='comment'>";
				if ($result[$i]['website']!="") {
					$return .= "<div class='name'><a href='".$result[$i]['website']."' title='".$result[$i]['website']."'>".$result[$i]['nama']."</a></div>";
				} else {
					$return .= "<div class='name'>".$result[$i]['nama']."</div>";
				}
				$return .= "<span class='date'>".$result[$i]['tanggal']."</span>";
				$return .= "<span class='time'>".$result[$i]['waktu']."</span>";
				$return .= "<div class='content'>".$result[$i]['comments']."</div>";
			$return .= "</div>"; //end of <div class='comment'>
			$return .= "<div class='reply'>";
				$return .= $this->getComments(false, $id, $result[$i]['id']);
			$return .= "</div>";
			$i++;
		}

		if ($commentBox==true) {
			/**
			 * PUT COMMENT BOX CODE HERE! DON'T FORGET TO ADD COMMENT HANDLING FUNCTION AND RE-CAPTCHA!
			 */
		}
		return $return;
	}
}

?>
