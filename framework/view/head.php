<?php
//pointer to the license file
include "../license.php";

class Head {
	private $title;

	public function Head($dbAccess) {
		$this->title = new Title($dbAccess);
	}

	public function printHead() {
		$return = "<div class='head'>";
		$return .= "<div class='title'><a href=''>".$this->title->getTitle()."</a></div>";
		$return .= "<div class='tagline'>".$this->title->getTagline()."</div>";
		$return .= "</div>";
		return $return;
	}
}

?>
