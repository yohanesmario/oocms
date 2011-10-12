<?php

class Book {
	private $article;

	public function Book(DBAccess $dbAccess, $id, $folder, $archive) {
		$dbAccess->connect();
		$this->article = new Article($dbAccess, $id, $folder, $archive);
	}

	public function printArticle($limit, $page, $comment, $id) {
		// NEED TO ADD ARCHIVE HANDLING!
		// NEED TO IMPLEMENT CLIENT_TIME_ZONE!
		$page = ($page==NULL || $page<=0)?1:$page;
		$comment = ($comment==NULL)?false:$comment;
		$limit = ($limit==NULL)?$this->article->getLimit():$limit;
		$i = $limit*($page-1);
		$iteration = 0;
		echo "<book>";
		while ($this->article->getID($i) && $iteration<$limit) {
			echo "<article>";
				echo "<title>".$this->article->getTitle($i)."</title>";
				echo "<author>".$this->article->getAuthor($i)."</author>";
				echo "<link>index.php?id=".$this->article->getID($i)."</link>";
				echo "<date>".$this->article->getGMTTime($i)."</date>";
				echo "<time>".$this->article->getGMTDate($i)."</time>";
				echo "<content>".$this->article->getContent($i)."</content>";
				echo "<footer>";
					if ($comment==false) {
							echo "<folder>".$this->article->getFolder($i)."</folder>";
							echo "<commentCount>".$this->article->countComments($this->article->getID($i))."</commentCount>";
					} else {
						//Comment section
						if ($id!=NULL) {
							echo "<comments>";
								$this->getComments(true, $this->article->getID($i), NULL);
							echo "</comments>";
						} else {
							echo "<comments>";
								$this->getComments(false, $this->article->getID($i), NULL);
							echo "</comments>";
						}
					}
				echo "</footer>";
			echo "</article>";
			$i++; $iteration++;
		}
		echo "</book>";
	}

	private function getComments($commentBox, $id, $reply) {
		$reply = ($reply==NULL)?0:$reply;
		$result = $this->article->commentDB($id, $reply);

		$i=0;
		while ($result[$i]) {
			echo "<comment>";
				if ($result[$i]['website']!="") {
					echo "<website>".$result[$i]['website']."</website>";
					echo "<name>".$result[$i]['nama']."</name>";
				} else {
					echo "<name>".$result[$i]['nama']."</name>";
				}
				echo "<date>".$result[$i]['tanggal']."</date>";
				echo "<time>".$result[$i]['waktu']."</time>";
				echo "<content>".htmlspecialchars($result[$i]['comments'])."</content>";
			echo "</comment>";
			echo "<reply>";
				$this->getComments(false, $id, $result[$i]['id']);
			echo "</reply>";
			$i++;
		}

		if ($commentBox==true) {
			/**
			 * PUT COMMENT BOX CODE HERE! DON'T FORGET TO ADD COMMENT HANDLING FUNCTION AND RE-CAPTCHA!
			 */
		}
	}
}

?>
