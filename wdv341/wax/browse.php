<?php
/*
	browse.php

	WaXchange PHP Project
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");

try {
	if (!empty($_POST)) {
		/* ajax responder */
		header('Content-Type: application/json');

		if (!isset($_GET['mode'])) {
			exit("{ \"error\": \"No mode specified\" }");
		}
		else {
			if (strcmp($_GET['mode'], "newest") == 0) {
				$st = $db->prepare("SELECT * FROM `albums` ORDER BY `posted` DESC LIMIT 6");
			}
			else if (strcmp($_GET['mode'], "expensive") == 0) {
				$st = $db->prepare("SELECT * FROM `albums` ORDER BY `price` DESC LIMIT 6");
			}
			else if (strcmp($_GET['mode'], "purchased") == 0) {
				$st = $db->prepare("SELECT * FROM `albums` WHERE `buyer`=:buyer ORDER BY `posted` DESC LIMIT 6");
				// $st = $db->prepare("SELECT * FROM `albums` WHERE `buyer`=:buyer ORDER BY `purchased` DESC LIMIT 6");
				if ($_SESSION['valid_user']) {
					$buyer = $_SESSION['current_user'];
				}
				else {
					$buyer = "oifdosifhodisahfodisahfodisahf";
				}
				$st->bindParam(":buyer", $buyer);
			}
			else if (strcmp($_GET['mode'], "artist") == 0) {
				if (!isset($_GET['a'])) {
					exit("{ \"error\": \"The artist mode must have an additional 'a' argument\" }");
				}
				$st = $db->prepare("SELECT * FROM `albums` WHERE `artist`=:artist ORDER BY `title` ASC");
				// $st = $db->prepare("SELECT * FROM `albums` WHERE `artist`=:artist ORDER BY `year` DESC");
				$st->bindParam(":artist", $_GET['a']);
			}
			else if (strcmp($_GET['mode'], "album") == 0) {
				if (!isset($_GET['b'])) {
					exit("{ \"error\": \"The album mode must have an additional 'b' argument\" }");
				}
				$st = $db->prepare("SELECT * FROM `albums` WHERE `title`=:title");
				$st->bindParam(":title", $_GET['b']);
			}
			else if (strcmp($_GET['mode'], "country") == 0) {
				if (!isset($_GET['c'])) {
					exit("{ \"error\": \"The country mode must have an additional 'c' argument\" }");
				}
				if (strlen($_GET['c']) > 2) {
					exit("{ \"error\": \"The c argument must be only 2 characters\" }");
				}
				$st = $db->prepare("SELECT * FROM `albums` WHERE `country`=:country ORDER BY `posted` DESC");
				$st->bindParam(":country", $_GET['c']);
			}
			else {
				/* assume newest */
				$st = $db->prepare("SELECT * FROM `albums` ORDER BY `posted` DESC");
			}
			$st->execute();
			header('Content-Type: application/json');

			$out = "[";
			$x = 0;
			while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
				if ($x > 0)
					$out .= ",\n";
				$out .= <<<EOF
				{
					"id": {$row['id']},
					"artist": "{$row['artist']}",
					"title": "{$row['title']}",
					"media": "{$row['media']}",
					"discs": {$row['discs']},
					"price": {$row['price']},
					"seller": "{$row['seller']}",
					"buyer": "{$row['buyer']}",
					"image": "{$row['image']}",
					"label": "{$row['label']}",
					"posted": "{$row['posted']}",
					"country": "{$row['country']}",
					"tracklist": {$row['tracklist']}
				}
EOF;
				$x++;
			}
			$out .= "]";
			exit($out);
		}
	}
	else {
		/* show a normal page */
		if (!isset($_SESSION['current_user'])) {
			$browse = new Page("header_guest", "browse");
			$browse->setTitle("WaXchange &bull; Browsing Releases");
			$browse->setDescription("Browse the newest, most expensive, and trending releases on the WaXchange marketplace.");
		}
		else {
			$browse = new Page("header_user", "browse");
			$browse->setTitle("WaXchange &bull; Browsing Releases");
		}
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}