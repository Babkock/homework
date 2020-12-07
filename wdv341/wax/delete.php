<?php
/*
	delete.php

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");
Methods::authorize();

try {
	if (!empty($_POST)) {
		if (!isset($_POST['choice'])) {
			$del = new Page("header_user", "about");
			$del->error("<p class=\"error\">Sorry, can't buy this album.</p>");
		}
		else if (strcmp($_POST['choice'], "Delete Album") == 0) {
			if (!isset($_GET['id'])) {
				$del = new Page("header_user", "about");
				$buy->error("<p class=\"error\">No 'id' argument given.</p>");
			}
			else {
				$del = new Page("header_user", "about");

				$album = new Album(intval($_GET['id']));
				$album->delete();

				$del->error("<h3>You have deleted " . $album->getArtist() . " - " . $album->getTitle() . "</h3>\n<p class=\"success\">This album is permanently deleted from the marketplace. If it was in someone's collection, it has been removed from their collection.</p>");
			}
		}
		else if (strcmp($_POST['choice'], "Cancel") == 0) {
			header('Location: index');
		}
		exit();
	}
	else {
		if (!isset($_GET['id'])) {
			$del = new Page("header_guest", "about");

			$del->error("<p class=\"error\">No 'id' argument given.</p>");
		}
		else {
			$album = new Album(intval($_GET['id']));
			$album->read();
			if (strcmp($_SESSION['current_user'], $album->getSeller()) != 0) {
				$del = new Page("header_guest", "about");

				$del->error("<p class=\"error\">You cannot delete this album since you didn't post it.</p>");
			}
			else {
				$del = new Page("header_user", "delete");
				$del->setTitle("Deleting {{ALBUM_TITLE}}");
				$del->setDescription("Are you sure you want to delete this album?");
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
				$sid = Methods::getIdFromName($row['seller']);

				$del->hreplacea([
					"USERID" => $uid,
					"ALBUM_TITLE" => $row['title']
				]);
				$del->replacea([
					"ALBUM_ID" => $row['id'],
					"ALBUM_ARTIST" => $row['artist'],
					"ALBUM_TITLE" => $row['title'],
					"ARTIST_HREF" => "browse?a=" . urlencode($row['artist']),
					"ALBUM_HREF" => "browse?b=" . urlencode($row['title']),
					"ALBUM_PRICE" => $row['price'],
					"ALBUM_LABEL" => $row['label'],
					"ALBUM_DISCS" => $row['discs'],
					"ALBUM_MEDIA" => $row['media'],
					"ALBUM_SELLER" => $row['seller'],
					"SELLER_HREF" => "user?id=" . $sid,
					"ALBUM_POSTED" => date("F j, Y", strtotime($row['posted'])),
					"ALBUM_COUNTRY" => Methods::countryExpand($row['country']),
					"TRACKLIST" => $tlout
				]);
			}
		}
		$del->output();
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">{$e->getMessage()}</p>");
}

