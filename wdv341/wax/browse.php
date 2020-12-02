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
			/* not logged in */
			
			if (isset($_GET['a'])) {       // artist
				$browse = new Page("header_guest", "browse_specific");
				$browse->script("waxBrowse.min.js");
				$browse->replacea([
					"USERID" => "0",
					"HEADING" => "Browsing Artist " . $_GET['a'],
					"BROWSE_ARTIST" => $_GET['a'],
					"BROWSE_ALBUM" => "",
					"BROWSE_COUNTRY" => $_GET['c'] ?? "",
					"BROWSE_GET" => "a",
					"BROWSE_GET_VALUE" => $_GET['a'],
					"BUYBUTTON" => "<button class=\"buy\" @click=\"Register()\">Buy This Album</button>"
				]);

				$browse->setTitle($_GET['a'] . " &bull; WaXchange");
				$browse->setDescription("The WaXchange artist page for " . $_GET['a'] . ". This shows all releases, all sellers, from all countries. WaXchange is a new music marketplace.");
			}
			else if (isset($_GET['b'])) {  // album
				$browse = new Page("header_guest", "browse_specific");
				$browse->script("waxBrowse.min.js");
				$browse->replacea([
					"USERID" => "0",
					"HEADING" => "<i>" . $_GET['b'] . "</i>",
					"BROWSE_ARTIST" => "",
					"BROWSE_ALBUM" => $_GET['b'],
					"BROWSE_COUNTRY" => $_GET['c'] ?? "",
					"BROWSE_GET" => "b",
					"BROWSE_GET_VALUE" => $_GET['b'],
					"BUYBUTTON" => "<button class=\"buy\" @click=\"Register()\">Buy This Album</button>"
				]);

				$browse->setTitle($_GET['b'] . " &bull; WaXchange");
				$browse->setDescription("All listings of " . $_GET['b'] . " on WaXchange. This page includes all sellers, from all countries. WaXchange is a new music marketplace.");
			}
			else if (isset($_GET['c'])) {  // country
				$browse = new Page("header_guest", "browse_specific");
				$browse->script("waxBrowse.min.js");
				$country = Methods::countryExpand($_GET['c']);

				$browse->replacea([
					"USERID" => "0",
					"HEADING" => "Sellers from " . $country,
					"BROWSE_ARTIST" => "",
					"BROWSE_ALBUM" => "",
					"BROWSE_COUNTRY" => $_GET['c'],
					"BROWSE_GET" => "c",
					"BROWSE_GET_VALUE" => $_GET['c'],
					"BUYBUTTON" => "<button class=\"buy\" @click=\"Register()\">Buy This Album</button>"
				]);

				$browse->setTitle("WaXchange &bull; " . $country . " Market");
				$browse->setDescription("All WaXchange releases for sale from " . $country . ". This page includes all releases.");
			}
			else {
				/* showing a single album */
				if (isset($_GET['id'])) {
					$browse = new Page("header_guest", "browse_specific");
					$browse->script("waxBrowse.min.js");
					$browse->replacea([
						"USERID" => "0",
						"HEADING" => "Album #" . $_GET['id'],
						"BROWSE_ARTIST" => "",
						"BROWSE_ALBUM" => "",
						"BROWSE_COUNTRY" => "",
						"BROWSE_GET" => "id",
						"BROWSE_GET_VALUE" => "",
						"BUYBUTTON" => "<button class=\"buy\" @click=\"Register()\">Buy This Album</button>"
					]);

					$browse->replace("BROWSE_GET_VALUE");
					$browse->setTitle("WaXchange &bull; Album #" . $_GET['id']);

					$st = $db->prepare("SELECT `artist`, `album`, `seller`, `country` FROM `albums` WHERE `id`=:id");
					$st->bindParam(":id", intval($_GET['id']));
					$st->execute();

					$row = $st->fetch(PDO::FETCH_ASSOC);
					$country = Methods::countryExpand($row['country']);

					$browse->setDescription("WaXchange album #" . $_GET['id'] . ": " . $row['artist'] . " - " . $row['album'] . ", for sale from " . $row['seller'] . " in " . $country . ". This is an individual listing.");
				}
				else {
					$browse = new Page("header_guest", "browse");
					$browse->script("waxBrowse.min.js");
					$browse->replacea([
						"USERID" => "0",
						"HEADING" => "",
						"BROWSE_ARTIST" => "",
						"BROWSE_ALBUM" => "",
						"BROWSE_COUNTRY" => "",
						"BROWSE_GET" => "",
						"BROWSE_GET_VALUE" => "",
						"BUYBUTTON" => "<button class=\"buy\" @click=\"Register()\">Buy This Album</button>"
					]);

					$browse->setTitle("WaXchange &bull; Browse");
					$browse->setDescription("Browsing the newest, most expensive, and trending releases on the WaXchange marketplace.");
				}
			}
		}
		else {
			/* logged in */
			$uid = Methods::getIdFromName($_SESSION['current_user']);

			if (isset($_GET['a'])) {    // artist
				$browse = new Page("header_user", "browse_specific");
				$browse->script("waxBrowse.min.js");
				$browse->hreplace("USERID", "" . $uid);
				$browse->replacea([
					"USERID" => "" . $uid,
					"HEADING" => "Browsing Artist " . $_GET['a'],
					"BROWSE_ARTIST" => $_GET['a'],
					"BROWSE_ALBUM" => "",
					"BROWSE_COUNTRY" => $_GET['c'] ?? "",
					"BROWSE_GET" => "a",
					"BROWSE_GET_VALUE" => $_GET['a'],
					"BUYBUTTON" => "<button class=\"buy\" @click=\"BuyAlbum(al.id)\">Buy This Album</button>"
				]);

				$browse->setTitle($_GET['a'] . " &bull; WaXchange");
				$browse->setDescription("The WaXchange artist page for " . $_GET['a'] . ". This shows all releases, all sellers, from all countries. WaXchange is a new music marketplace.");
			}
			else if (isset($_GET['b'])) {    // album
				$browse = new Page("header_user", "browse_specific");
				$browse->script("waxBrowse.min.js");
				$browse->hreplace("USERID", "" . $uid);
				$browse->replacea([
					"USERID" => "" . $uid,
					"HEADING" => "<i>" . $_GET['b'] . "</i>",
					"BROWSE_ARTIST" => "",
					"BROWSE_ALBUM" => $_GET['b'],
					"BROWSE_COUNTRY" => $_GET['c'] ?? "",
					"BROWSE_GET" => "b",
					"BROWSE_GET_VALUE" => $_GET['b'],
					"BUYBUTTON" => "<button class=\"buy\" @click=\"BuyAlbum(al.id)\">Buy This Album</button>"
				]);

				$browse->setTitle($_GET['b'] . " &bull; WaXchange");
				$browse->setDescription("All listings of " . $_GET['b'] . " on WaXchange. This page includes all sellers, from all countries. WaXchange is a new music marketplace.");
			}
			else if (isset($_GET['c'])) {   // country
				$browse = new Page("header_user", "browse_specific");
				$browse->script("waxBrowse.min.js");
				$country = Methods::countryExpand($_GET['c']);

				$browse->hreplace("USERID", "" . $uid);
				$browse->replacea([
					"USERID" => "" . $uid,
					"HEADING" => "Sellers from " . $country,
					"BROWSE_ARTIST" => "",
					"BROWSE_ALBUM" => "",
					"BROWSE_COUNTRY" => $_GET['c'],
					"BROWSE_GET" => "c",
					"BROWSE_GET_VALUE" => $_GET['c'],
					"BUYBUTTON" => "<button class=\"buy\" @click=\"BuyAlbum(al.id)\">Buy This Album</button>"
				]);

				$browse->setTitle("WaXchange &bull; " . $country . " Market");
				$browse->setDescription("All WaXchange releases for sale from " . $country . ". This page includes all releases.");
			}
			else {
				/* showing a single album */
				if (isset($_GET['id'])) {
					$browse = new Page("header_user", "browse_specific");
					$browse->script("waxBrowse.min.js");
					$browse->hreplace("USERID", "" . $uid);
					$browse->replacea([
						"USERID" => "" . $uid,
						"HEADING" => "Album #" . $_GET['id'],
						"BROWSE_ARTIST" => "",
						"BROWSE_ALBUM" => "",
						"BROWSE_COUNTRY" => "",
						"BROWSE_GET" => "id",
						"BROWSE_GET_VALUE" => "",
						"BUYBUTTON" => "<button class=\"buy\" @click=\"BuyAlbum(al.id)\">Buy This Album</button>"
					]);

					$browse->setTitle("WaXchange &bull; Album #" . $_GET['id']);

					$st = $db->prepare("SELECT `artist`, `album`, `seller`, `country` FROM `albums` WHERE `id`=:id");
					$st->bindParam(":id", intval($_GET['id']));
					$st->execute();

					$row = $st->fetch(PDO::FETCH_ASSOC);
					$country = Methods::countryExpand($row['country']);

					$browse->setDescription("WaXchange album #" . $_GET['id'] . ": " . $row['artist'] . " - " . $row['album'] . ", for sale from " . $row['seller'] . " in " . $country . ". This is an individual listing.");
				}
				else {
					$browse = new Page("header_user", "browse");
					$browse->script("waxBrowse.min.js");
					$browse->hreplace("USERID", "" . $uid);
					$browse->replacea([
						"USERID" => "0",
						"HEADING" => "",
						"BROWSE_ARTIST" => "",
						"BROWSE_ALBUM" => "",
						"BROWSE_COUNTRY" => "",
						"BROWSE_GET" => "",
						"BROWSE_GET_VALUE" => "",
						"BUYBUTTON" => "<button class=\"buy\" @click=\"BuyAlbum(al.id)\">Buy This Album</button>"
					]);

					$browse->setTitle("WaXchange &bull; Browse");
					$browse->setDescription("Browsing the newest, most expensive, and trending releases on the WaXchange marketplace.");
				}
			}
		}
		$browse->output();
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
