<?php
/*
	Unit 12: SQL INSERT
	November 12, 2020
	Tanner Babcock
*/
require_once("dbConnect.php");

try {
	if (!empty($_POST)) {
		if ($_SESSION['valid_user'] === true) {

			if (!isset($_POST['event_name']) || !isset($_POST['event_presenter']) || !isset($_POST['event_date']) || !isset($_POST['event_description']) || !isset($_POST['event_time'])) {
				exit("<html><head><title>Error</title></head><body><p class=\"error\">One or more fields are empty.</p></body></html>");
			}
			else {
				$name = $_POST['event_name'];
				$presenter = $_POST['event_presenter'];
				$tdate = $_POST['event_date'];
				$ttime = $_POST['event_time'];
				$descript = $_POST['event_description'];

				$st = $db->prepare("INSERT INTO `wdv341_events` VALUES (id, :name, :description, :presenter, :tdate, :ttime)");
				$st->bindParam(":id", $id);
				$st->bindParam(":name", $name);
				$st->bindParam(":description", $descript);
				$st->bindParam(":presenter", $presenter);
				$st->bindParam(":tdate", $tdate);
				$st->bindParam(":ttime", $ttime);

				$st->execute();
?>
<!DOCTYPE html>
<!--
	Unit 12: SQL INSERT
	November 12, 2020
	Tanner Babcock
-->
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Form Submission Successful!</title>
		<link rel="stylesheet" href="/homework/assets/css/style.css" />
		<link rel="icon" href="/images/favicon.png" />
	</head>
	<body>
		<center>
			<h2>Event successfully submitted. <a href="selectEvents">View it in the table, here.</a></h2>
		</center>
		<footer>
			<p><a href="/homework/index?c=wdv341">&rarr; Return to WDV341 Homework &larr;</a> &bull; <a href="https://github.com/Babkock/homework/blob/master/wdv341/insertEvents.php" target="_blank" title="GitHub" alt="GitHub">View Source Code</a></p>
		</footer>
	</body>
</html>
	<?php
			}
		}
		else {
			header('Location: login');
		}
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}