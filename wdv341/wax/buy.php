<?php
/*
	buy.php

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");
Methods::authorize();

try {
	if (!empty($_POST)) {
		if (!isset($_POST['choice'])) {
			exit("<p class=\"error\">Sorry, can't buy this album.</p>");
		}
		else if (strcmp($_POST['choice'], "Buy This Album") == 0) {
			if (!isset($_GET['id'])) {
				exit("<p class=\"error\">No 'id' argument given.</p>");
			}
			else {
				$album = new Album();
				$album->read(intval($_GET['id']));

				$album->purchase($_SESSION['current_user']);

				exit("<p class=\"success\">You have purchased this album! Thank you for your business. <a href=\"index\">View your purchases here.</a></p>");
			}
		}
	}
	else {
		$buy = new Page("header_user", "buy_confirm");
		$buy->setTitle("Buying {{ALBUM_TITLE}}");
		$buy->setDescription("This is the purchase confirmation page for the album {{ALBUM_ARTIST}} - {{ALBUM_TITLE}}. It costs $ {{ALBUM_PRICE}}.");
		if (!isset($_GET['id'])) {
			$buy->error("No 'id' argument given.");
			exit();
		}
		else {
			/* $album = new Album();
			$album->read(intval($_GET['id']));
			
			*/
			$uid = Methods::getIdFromName($_SESSION['current_user']);

			$st = $db->prepare("SELECT * FROM `albums` WHERE `id`=:id");
			$st->bindParam(":id", intval($_GET['id']));
			$st->execute();

			$row = $st->fetch(PDO::FETCH_ASSOC);
			$country = Methods::countryExpand($row['country']);

			$tl = json_decode($row['tracklist']);
			$tlout = "<ol>";

			foreach ($tl as $k => $v) {
				$tlout .= <<<EOF
				<li>{$v->title} <i>($v->length)</i></li>
EOF;
			}
			$tlout .= "</ol>";

			$buy->hreplacea([
				"USERID" => $uid,
				"ALBUM_TITLE" => $row['title'],
				"ALBUM_ARTIST" => $row['artist'],
				"ALBUM_PRICE" => $row['price']
			]);
			$buy->replacea([
				"USERNAME" => $_SESSION['current_user'],
				"ALBUM_ID" => $row['id'],
				"ALBUM_HREF" => "browse?b=" . urlencode(ucwords($row['title'])),
				"ARTIST_HREF" => "browse?a=" . urlencode(ucwords($row['artist'])),
				"ALBUM_TITLE" => $row['title'],
				"ALBUM_ARTIST" => $row['artist'],
				"ALBUM_MEDIA" => $row['media'],
				"ALBUM_PRICE" => $row['price'],
				"ALBUM_IMAGE" => $row['image'],
				"ALBUM_DISCS" => $row['discs'],
				"ALBUM_POSTED" => date("F j, Y", strtotime($row['posted'])),
				"ALBUM_LABEL" => $row['label'],
				"ALBUM_COUNTRY" => $country,
				"ALBUM_SELLER" => $row['seller'],
				"TRACKLIST" => $tlout
			]);
		}
		$buy->output();
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
