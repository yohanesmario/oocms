<?php
//pointer to the license file
include "../license.php";

class Book {
	private $article;
	private $tab;
	private $janitor;
	private $sessionArray;

	public function Book(Janitor $janitor, DBAccess $dbAccess, $id, $folder, $archive, $sessionArray) {
		$this->article = new Article($dbAccess, $id, $folder, $archive);
		$this->tab = new Tab($dbAccess);
		$this->janitor = $janitor;
		$this->sessionArray = $sessionArray;
	}

	public function printBook($limit, $page, $comment, $id, $folder, $archive, $tab) {
		$return = "<span class='book'>\n";

		if ($tab!=NULL) {
			$return .= $this->printTab($tab);
		} else {
			$page = ($page==NULL || $page<=0)?1:$page;
			$return .= $this->printArticle($limit, $page, $comment, $id, $this->janitor);
			if ($this->janitor->validatePage((intval($page)+1)."", $id, $folder, $archive) || $this->janitor->validatePage((intval($page)-1)."", $id, $folder, $archive)) {
				$return .= "<div class='pagination'>\n";
				if($this->janitor->validatePage((intval($page)+1)."", $id, $folder, $archive)) {
					$return .= "<span class='older'><a href='?";
					if ($folder!=NULL) {
						$return .= "folder=".$folder."&";
					}
					if ($archive!=NULL) {
						$return .= "archive=".$archive."&";
					}
					$return .= "page=".(intval($page)+1)."'>&lt; older page</a></span>";
				}
				if($this->janitor->validatePage((intval($page)-1)."", $id, $folder, $archive)) {
					$return .= "<span class='newer'><a href='?";
					if ($folder!=NULL) {
						$return .= "folder=".$folder."&";
					}
					if ($archive!=NULL) {
						$return .= "archive=".$archive."&";
					}
					$return .= "page=".(intval($page)-1)."'>newer page &gt;</a></span>";
				}
				$return .= "</div>\n";
			}
		}

		$return .= "</span>"; //end of <span class='book'>
		return $return;
	}

	private function printTab($id) {
		$return = "<div class='tab'>\n";
		$return .= "<div class='title'><a href='?tab=".$this->tab->getID($id)."'>".$this->tab->getTitle($id)."</a></div>\n";
		$return .= "<div class='content'>".$this->tab->getContent($id)."</div>\n";
		$return .= "</div>\n";
		return $return;
	}

	private function printArticle($limit, $page, $comment, $id, $janitor) {
		$comment = ($comment==NULL)?false:$comment;
		$limit = ($limit==NULL)?$this->article->getLimit():$limit;
		$i = $limit*($page-1);
		$iteration = 0;

		while ($this->article->getID($i) && $iteration<$limit) {
			$return .= "<div class='article'>\n";
				$return .= "<div class='title'><a title='By : ".$this->article->getAuthor($i)."' href='?id=".$this->article->getID($i)."'>".$this->article->getTitle($i)."</a></div>\n";
				$return .= "<div class='date_time'>";
				$return .= "<span class='date'>".$this->article->getDate($i)."</span>";
				$return .= " - "; //separator
				$return .= "<span class='time'>".$this->article->getTime($i)."</span>\n";
				$return .= "</div>";
				$return .= "<div class='content'>".$this->article->getContent($i)."</div>\n";
				$return .= "<div class='footer'>\n";
					if ($comment==false) {
						$return .= "<span class='folder'>Posted in <a href='?folder=".$this->article->getFolder($i)."'>".$this->article->getFolder($i)."</a></span>";
						$return .= " | "; //separator
						if ($this->article->countComments($this->article->getID($i)) > 1) {
							$return .= "<span class='commentCount'><a href='?id=".$this->article->getID($i)."#comments'>".$this->article->countComments($this->article->getID($i))." comments</a></span>\n";
						} else if ($this->article->countComments($this->article->getID($i)) > 0) {
							$return .= "<span class='commentCount'><a href='?id=".$this->article->getID($i)."#comments'>".$this->article->countComments($this->article->getID($i))." comment</a></span>\n";
						} else {
							$return .= "<span class='commentCount'><a href='?id=".$this->article->getID($i)."#comments'>Add a comment</a></span>\n";
						}

					} else {
						//Comment section
						if ($id!=NULL) {
							$return .= "<div class='comments' id='comments'>\n";
								$return .= $this->getComments(true, $this->article->getID($i), NULL, $janitor);
							$return .= "</div>\n";
						} else {
							$return .= "<div class='comments' id='comments'>\n";
								$return .= $this->getComments(false, $this->article->getID($i), NULL, $janitor);
							$return .= "</div>\n";
						}
					}
				$return .= "</div>\n"; //end of <div class='footer'>
			$return .= "</div>\n"; //end of <div class='article'>
			$i++; $iteration++;
		}
		return $return;
	}

	private function getComments($commentBox, $id, $reply, $janitor) {
		$reply = ($reply==NULL)?0:$reply;
		$result = $this->article->commentDB($id, $reply);

		$i=0;
		$return="";

		while ($result[$i]) {
			$return .= "<div class='comment'>\n";
				if ($result[$i]['website']!="") {
					$return .= "<div class='name' id='".$result[$i]['commenter_type']."'><a href='".$result[$i]['website']."' title='".$result[$i]['website']."'>".$result[$i]['commenter_name']."</a></div>\n";
				} else {
					$return .= "<div class='name'>".$result[$i]['commenter_name']."</div>\n";
				}
				$return .= "<span class='date'>".$result[$i]['comment_date']."</span> - ";
				$return .= "<span class='time'>".$result[$i]['comment_time']."</span>\n";
				$return .= "<div class='content'>".$result[$i]['comments']."</div>\n";
				$return .= "<div class='reply_button'><a href='#comment_box' onclick=\"document.getElementById('replyto').value='".$result[$i]['website']."'; document.getElementById('replytobutton').type='button'; document.getElementById('replytomessage').innerHTML='you are replying to ".$result[$i]['commenter_name']."';\">Reply</a></div>";
			$return .= "</div>\n"; //end of <div class='comment'>
			$return .= "<div class='reply'>\n";
				$return .= $this->getComments(false, $id, $result[$i]['id'], $janitor);
			$return .= "</div>\n";
			$i++;
		}

		if ($commentBox==true) {
			$return .= "<form id='comment_box' method='POST' action=''>
					<p>".(($this->sessionArray['logged_in'])?("You're logged in as ".$this->sessionArray['fullname']."."):("Name:<br />
						<input class='text' type='text' name='name' size=40 value='".$this->sessionArray['fullname']."' placeholder='enter your name here' />
					</p>

					<p>Email (not published):<br />
						<input class='text' type='email' placeholder='enter your email here' name='email' size=40 value='".$this->sessionArray['email']."' />
					</p>

					<p>Website (optional):<br />
						<input class='text' type='url' name='website' size=40 value='".$this->sessionArray['website']."' placeholder='enter your website url here (optional)' />
					"))."</p>

					<p>Comment:<br />
						<textarea id='commenttextarea' class='text' name='comment' rows=5 cols=40></textarea>
					</p>

					<p><input class='submit' type='submit' value='Submit Comment'>&nbsp;&nbsp;<span id='replytomessage'></span>&nbsp;&nbsp;<input id='replytobutton' type='hidden' value='Cancel' onClick=\"this.type='hidden'; document.getElementById('replyto').value='0'; document.getElementById('replytomessage').innerHTML='';\" /></p><input type='hidden' name='id' value=".$id." /><input id='replyto' type='hidden' name='replyto' value='0' /></form>";
		}

		return $return;
	}

	public function getTabTitle($tab) {
		return $this->tab->getTitle($tab);
	}

	public function getArticleTitle() {
		return $this->article->getTitle(0);
	}
}

?>
