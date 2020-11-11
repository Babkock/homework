<!DOCTYPE html>
<?php
/*
	Unit 13: Login and Protected Pages
	November 10, 2020
	Tanner Babcock
*/
session_start();
require_once("dbConnect.php");

function showAdminArea() {
	?>
<html lang="en">
<head>

</head>
<body>

</body>
</html>
	<?php
}

function showLoginForm($warning = false, $user = "") {
	?>
<html lang="en">
<head>

</head>
<body>

</body>
</html>
	<?php
}

try {
	if (!empty($_POST)) {
		$st = $db->prepare("SELECT `event_user_id`, `event_user_name`, `event_user_password` FROM `event_user`");
		$st->execute();

		$_SESSION['validUser'] = false;
		while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
			if ((strcmp($row['event_user_name'], $_POST['username']) == 0) &&
				(strcmp($row['event_user_password'], $_POST['password']) == 0)) {
				$_SESSION['validUser'] = true;
				break;
			}
		}

		if ($_SESSION['validUser'] == true) {
			header('Location: /homework/wdv341/login');
			exit();
		}
		else {
			/* show login form with error */
			showLoginForm(true, $_POST['username']);
		}
	}
	else {
		if ($_SESSION['validUser'] == true) {
			showAdminArea();
		}
		else {
			/* show login form */
			showLoginForm();
		}
	}

}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
