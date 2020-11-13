<?php
/*
	Unit 12: SQL INSERT
	November 12, 2020
	Tanner Babcock
*/
require_once("dbConnect.php");

try {
	if (!empty($_POST)) {
		if (!isset($_POST['event_name']) || !isset($_POST['event_presenter']) || !isset($_POST['event_date']) || !isset($_POST['event_description']) || !isset($_POST['event_time'])) {
			exit("<html><head><title>Error</title></head><body><p class=\"error\">One or more fields are empty.</p></body></html>");
		}
		else {
			$id = intval($_POST['event_id']);
			$name = $_POST['event_name'];
			$presenter = $_POST['event_presenter'];
			$tdate = $_POST['event_date'];
			$ttime = $_POST['event_time'];
			$descript = $_POST['event_description'];

			$st = $db->prepare("INSERT INTO `wdv341_events` VALUES (:id, :name, :description, :presenter, :tdate, :ttime)");
			$st->bindParam(":id", $id);
			$st->bindParam(":name", $name);
			$st->bindParam(":description", $descript);
			$st->bindParam(":presenter", $presenter);
			$st->bindParam(":tdate", $tdate);
			$st->bindParam(":ttime", $ttime);

			$st->execute();
?>

<?php
		}
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}