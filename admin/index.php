<?php

include "../framework/includes.php"; //include all listed classes. If you make custom classes, please ensure that they are already listed in the file.

$dbAccess = new DBAccess(); //core model layer
$janitor = new Janitor($dbAccess); //core controller layer

$httpGetArray = $janitor->sanitizeHTTPGet();

$id = $httpGetArray['id'];

$session = new Session($janitor);
if($_GET['action']=='logout') {
	$session->endSession();
} else {
	if ($_POST['username']!=NULL && $_POST['password']!=NULL) {
		$session->registerSession($_POST['username'], $_POST['password']);
	}
}
$sessionArray = $session->getSessionArray();

$janitor->processArticle($sessionArray);
$janitor->processTab($sessionArray);

$admin = new Admin($janitor, $dbAccess, $id, $sessionArray);

$adminResult = $admin->printAdmin();

?>
<!DOCTYPE html>
	<head>
		<title>Admin Page</title>
	</head>
	<body>
		<?php echo $adminResult; ?>
	</body>
</html>
