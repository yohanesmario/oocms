<?php
//pointer to the license file
include "../license.php";

class Sidebar {
	private $widget;

	public function Sidebar(DBAccess $dbAccess) {
		$this->widget = new Widget($dbAccess);

		$i=0;
		while($this->widget->getID($i)) {
			if ($this->widget->getType($i)!='text') {
				$this->setWidgetContent($dbAccess, $i, $this->widget->getType($i));
			}
			$i++;
		}
	}

	private function setWidgetContent(DBAccess $dbAccess, $i, $type) {
		switch($type) {
			case 'folder' : //signature: folder-system
				$object = new Folder($dbAccess);
				$result = "<div class='title'>Folders</div>\n<ul>\n";
				$iteration = 0;
				while($object->getFolder($iteration)) {
					$result .= "<li><a href='?folder=".$object->getFolder($iteration)."'>".$object->getFolder($iteration)."</a></li>\n";
					$iteration++;
				}
				$result .= "</ul>";
				$this->widget->setContent($i, $result);
				break;

			case 'archive' : //signature: archive-system
				$object = new Archive($dbAccess);
				$result = "<div class='title'>Archive</div>\n<ul>\n";
				$iteration = 0;
				while($object->getArchive($iteration)) {
					$result .= "<li><a href='?archive=".$object->getArchive($iteration)."'>".$object->getYear($iteration)." - ".$object->getMonth($iteration)."</a></li>\n";
					$iteration++;
				}
				$result .= "</ul>";
				$this->widget->setContent($i, $result);
				break;

			case 'blogroll' :  //signature: blogroll-system
				$object = new Blogroll($dbAccess);
				$result = "<div class='title'>Blogroll</div>\n<ul>\n";
				$iteration = 0;
				while($object->getName($iteration)) {
					$result .= "<li><a href='".$object->getBlog($iteration)."'>".$object->getName($iteration)."</a></li>\n";
					$iteration++;
				}
				$result .= "</ul>";
				$this->widget->setContent($i, $result);
				break;

			case 'image' :  //signature: image-system
				$result = explode(":separator:",$this->widget->getContent($i));
				$result = "<center><img src='".$result[0]."' alt='".$result[1]."' /></center>";
				$this->widget->setContent($i, $result);
				break;
			//BEGIN WIDGET EXTENSION

			//END WIDGET EXTENSION
			default :
				$this->widget->setContent($i, "Widget is not registered. Please contact your theme developer.");
				break;
		}
	}

	public function printSidebar() {
		$return = "<span class='sidebar'>\n";
		
		$i=0;
		while($this->widget->getID($i)) {
			$return .= "<div class='widget'>\n".$this->widget->getContent($i)."</div>\n";
			$i++;
		}
		
		$return .= "</span>";
		return $return;
	}
}

?>
