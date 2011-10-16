<?php
//pointer to the license file
include "../license.php";

class Menu {
	private $tabs;

	public function Menu(DBAccess $dbAccess) {
		$this->tabs = new Tabs($dbAccess);
	}

	public function printMenu() {
		$return = "<div class='menu'>\n";
		$return .= "<ul class='menu_container'>\n";
		$return .= "<li class='menu_item'><a href='".$_SERVER['PHP_SELF']."'>Home</a></li>\n";
		$i = 0;
		while($this->tabs->getID($i)) {
			$return .= "<li class='menu_item'><a href='?tab=".$this->tabs->getID($i)."'>".$this->tabs->getTitle($i)."</a></li>\n";
			$i++;
		}
		$return .= "</ul>\n</div>";
		return $return;
	}
}

?>
