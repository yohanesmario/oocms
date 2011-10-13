<?php
/*********************************************************************************
 * This is only a basic example of a typical index.php file using the framework. *
 * You can change it to your liking.                                             *
 *********************************************************************************/

include "framework/includes.php"; //include all listed classes. If you make custom classes, please ensure that they are already listed in the file.

$dbAccess = new DBAccess(); //core model layer
$janitor = new Janitor($dbAccess); //core controller layer

//Never forget to sanitize all input! Use the Janitor class for every input accordingly! (that's one of the purpose of MVC architecture)
$id = ($janitor->validateID($_GET['id'])) ? $_GET['id'] : NULL; //..................................... sanitize $_GET['id']
$folder = ($janitor->validateFolder($_GET['folder'])) ? $_GET['folder'] : NULL; //..................... sanitize $_GET['folder']
$archive = ($janitor->validateArchive($_GET['archive'])) ? $_GET['archive'] : NULL; //................. sanitize $_GET['archive']
$page = ($janitor->validatePage($_GET['page'], $id, $folder, $archive)) ? $_GET['page'] : NULL; //..... sanitize $_GET['page']
//I use conditional operator to shorten the sanitization code above. To learn about conditional operator, just google "conditional operator php".

$book = new Book($dbAccess, $id, $folder, $archive); //book view

$bookResult = $book->printArticle(NULL, $page, ($id!=NULL)?true:false, $id); //contain the book span HTML in a string
echo $bookResult;
?>
