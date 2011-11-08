<?php
//pointer to the license file
include "../license.php";

class Admin {
	private $id;
	private $article;
	private $tab;
	private $janitor;
	private $sessionArray;

	public function Admin(Janitor $janitor, DBAccess $dbAccess, $id, $sessionArray) {
		$this->id = $id;
		$this->article = new Article($dbAccess, $id, NULL, NULL);
		$this->tab = new Tab($dbAccess);
		$this->janitor = $janitor;
		$this->sessionArray = $sessionArray;
	}

	public function printAdmin() {
		if ($this->sessionArray['logged_in']==true) {
			switch ($_GET['section']) {
				case "article" : $return .= $this->printArticleForm(); break;
				case "tab"     : $return .= $this->printTabForm(); break;
				default        : $return .= "HOME"; break;
			}
		} else {
			$return .= $this->printLoginForm();
		}
		return $return;
	}

	private function printLoginForm() {
		$return .= "<form id='login_form' method='POST' action=''>";
		$return .= "<p>User Name:</p><input type='text' name='username' value='' />";
		$return .= "<p>Password:</p><input type='password' name='password' value='' />";
		$return .= "<p><input type='submit' name='login' value='Login' /></p>";
		$return .= "</form>\n";
		return $return;
	}

	private function printArticleForm() {
		if ($this->id==NULL) {
			$return .= "<form id='article_form' method='POST' action=''>";
			$return .= "<p>Article Title:</p><input type='text' name='title' value='' />";
			$return .= "<p>Folder:</p><input type='text' name='folder' value='' />";
			$return .= "<p>Content:</p><textarea name='content' rows=5 cols=40></textarea>";
			$return .= "<p><input type='submit' name='submitArticle' value='Submit Article' /></p>";
			$return .= "</form>\n";
		} else {
			$return .= "<form id='article_form' method='POST' action=''>";
			$return .= "<input type='hidden' name='id' value='".$this->article->getID(0)."' />";
			$return .= "<p>Article Title:</p><input type='text' name='title' value='".$this->article->getTitle(0)."' />";
			$return .= "<p>Folder:</p><input type='text' name='folder' value='".$this->article->getFolder(0)."' />";
			$return .= "<p>Content:</p><textarea name='content' rows=5 cols=40>".$this->article->getContent(0)."</textarea>";
			$return .= "<p><input type='submit' name='submitArticle' value='Update Article' /></p>";
			$return .= "</form>\n";
		}
		return $return;
	}

	private function printTabForm() {
		if ($this->id==NULL) {
			$return .= "<form id='tab_form' method='POST' action=''>";
			$return .= "<p>Tab Title:</p><input type='text' name='title' value='' />";
			$return .= "<p>Content:</p><textarea name='content' rows=5 cols=40></textarea>";
			$return .= "<p><input type='submit' name='submitTab' value='Submit Tab' /></p>";
			$return .= "</form>\n";
		} else {
			$return .= "<form id='tab_form' method='POST' action=''>";
			$return .= "<input type='hidden' name='id' value='".$this->tab->getID($this->id)."' />";
			$return .= "<p>Tab Title:</p><input type='text' name='title' value='".$this->tab->getTitle($this->id)."' />";
			$return .= "<p>Content:</p><textarea name='content' rows=5 cols=40>".$this->tab->getContent($this->id)."</textarea>";
			$return .= "<p><input type='submit' name='submitTab' value='Update Tab' /></p>";
			$return .= "</form>\n";
		}
		return $return;
	}
}

?>
