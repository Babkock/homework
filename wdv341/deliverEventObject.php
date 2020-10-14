<?php
/*
   Unit 9: Formatting JSON Output
   October 13, 2020
   Tanner Babcock
*/

try {
	require_once("dbConnect.php");

	$st = $db->prepare("SELECT * FROM `wdv341_events` WHERE `event_id`=1");

	$row = $st->fetch(PDO::FETCH_ASSOC);

	$output = new class {
		public $event_id;
		public $event_name;
		public $event_description;
		public $event_presenter;
		public $event_date;
		public $event_time;
	};

	$output->event_id = $row['event_id'];
	$output->event_name = $row['event_name'];
	$output->event_description = $row['event_description'];
	$output->event_presenter = $row['event_presenter'];
	$output->event_date = $row['event_date'];
	$output->event_time = $row['event_time'];

	header('Content-Type: application/json');

	echo json_encode($output);

	$db = null;

}
catch (PDOException $e) {
	http_response_code(500);
}
