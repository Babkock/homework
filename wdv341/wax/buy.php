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

				exit("<p class=\"error\">You have purchased this album! Thank you for your business. <a href=\"index\">View your purchases here.</a></p>");
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
			$album = new Album();
			$album->read(intval($_GET['id']));
			$uid = Methods::getIdFromName($_SESSION['current_user']);

			$tl = json_decode($album->getTracklist());
			$tlout = "";

			foreach ($tl as $k => $v) {
				$tlout .= "<li>" . $v->title . " <i>(" . $v->length . ")</i></li>\n\t\t\t";
			}

			$buy->hreplacea([
				"USERID" => $uid,
				"ALBUM_TITLE" => $album->getTitle(),
				"ALBUM_ARTIST" => $album->getArtist(),
				"ALBUM_PRICE" => $album->price
			]);
			$buy->replacea([
				"USERNAME" => $_SESSION['current_user'],
				"ALBUM_ID" => $album->getId(),
				"ALBUM_HREF" => "browse?b=" . urlencode(ucwords($album->getTitle())),
				"ARTIST_HREF" => "browse?a=" . urlencode(ucwords($album->getArtist())),
				"ALBUM_TITLE" => $album->getTitle(),
				"ALBUM_ARTIST" => $album->getArtist(),
				"ALBUM_MEDIA" => $album->getMedia(),
				"ALBUM_PRICE" => $album->price,
				"ALBUM_IMAGE" => $album->getImage(),
				"ALBUM_DISCS" => $album->getDiscs(),
				"ALBUM_LABEL" => $album->getLabel(),
				"ALBUM_COUNTRY" => $album->country,
				"ALBUM_SELLER" => $album->getSeller(),
				"ALBUM_TRACKS" => $tlout
			]);
		}
		$buy->output();
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
