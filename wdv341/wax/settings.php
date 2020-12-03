<?php
/*
	settings.php

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");
Methods::authorize();

try {
	if (!empty($_POST)) {

	}
	else {
		$settings = new Page("header_user", "settings");
		$settings->script("waxSettings.min.js");
		$settings->setTitle("WaXchange &bull; Settings");
		$settings->setDescription("This page lets you change your user preferences. This page is different for everyone.");

		$uid = Methods::getIdFromName($_SESSION['current_user']);

		$st = $db->prepare("SELECT * FROM `users` WHERE `id`=:id LIMIT 1");
		$st->bindParam(":id", $uid);
		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);

		/*
		switch ($row['showemail']) {
			case 1:
				$settings->replacea([
					"HIDE_SELECT" => "selected",
					"ABSTRACT_SELECT" => "",
					"SHOW_SELECT" => ""
				]);
				break;
			case 2:
				$settings->replacea([
					"HIDE_SELECT" => "",
					"ABSTRACT_SELECT" => "selected",
					"SHOW_SELECT" => ""
				]);
				break;
			case 3:
				$settings->replacea([
					"HIDE_SELECT" => "",
					"ABSTRACT_SELECT" => "",
					"SHOW_SELECT" => "selected"
				]);
				break;
		}
		$settings->replace("BIOGRAPHY", $row['biography']);
		*/

		$settings->output();
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
