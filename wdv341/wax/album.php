<?php
/*
	album.php

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");
Methods::authorize();

try {
	if (!empty($_POST)) {
		if (!isset($_POST['albumJson'])) {
			exit("<p class=\"error\">No album data sent!</p>");
		}
		else {
			if (isset($_GET['id'])) {
				$album = new Album(intval($_GET['id']));
				$json = json_decode($_POST['albumJson']);

				$tl = json_encode($json->tracklist);

				$album->seta([
					"artist" => $json->artist,
					"title" => $json->title,
					"media" => $json->media,
					"discs" => $json->discs,
					"price" => floatval($json->price),
					"seller" => $json->seller,
					"buyer" => $json->buyer,
					"image" => $json->image,
					"label" => $json->label,
					"posted" => $json->posted,
					"country" => $json->country,
					"tracklist" => $tl,
					"year" => intval($json->year),
					"currency" => $json->currency,
					"cond" => $json->cond,
					"purchased" => $json->purchased,
					"sellerid" => $json->sellerid,
					"buyerid" => $json->buyerid
				]);

				$album->update();

				exit("<p class=\"success\">Your changes to this album were saved. <a href=\"browse?id=" . $_GET['id'] . "\">View it here.</a></p>");
			}
			else {
				$album = new Album();
				$json = json_decode($_POST['albumJson']);

				if ((isset($_FILES['image'])) && ($_FILES['image']['error'] == 0)) {
					$filename = explode("/", $json->image)[2];
					$filetype = $_FILES['image']['type'];
					$filesize = $_FILES['image']['size'];

					$validtypes = [
						"jpg" => "image/jpg",
						"jpeg" => "image/jpeg",
						"png" => "image/png",
						"gif" => "image/gif"
					];

					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if (!array_key_exists($ext, $validtypes)) {
						exit("<p class=\"error\">That file type is not allowed. Only JPEG, PNG, and GIF images are allowed.</p>");
					}
					if ($filesize > (2 * 1024 * 1024)) {
						exit("<p class=\"error\">The file you selected is too big. Maximum size is 2 MB.</p>");
					}
					if (in_array($filetype, $validtypes)) {

						if (file_exists(__DIR__ . "/img/album/" . $filename)) {
							exit("<p class=\"error\">Filename already exists. Please choose a different name.</p>");
						}
						else {
							move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/img/album/" . $filename);
						}
					}
				}
				$tl = json_encode($json->tracklist);

				$album->seta([
					"artist" => $json->artist,
					"title" => $json->title,
					"media" => $json->media,
					"discs" => $json->discs,
					"price" => floatval($json->price),
					"seller" => $json->seller,
					"buyer" => $json->buyer,
					"image" => $json->image,
					"label" => $json->label,
					"posted" => $json->posted,
					"country" => $json->country,
					"tracklist" => $tl,
					"year" => intval($json->year),
					"currency" => $json->currency,
					"cond" => $json->cond,
					"purchased" => $json->purchased,
					"sellerid" => $json->sellerid,
					"buyerid" => $json->buyerid
				]);

				$album->write();

				exit("<p class=\"success\">Your album was uploaded successfully! <a href=\"index\">Go back to your Dashboard.</a></p>");
			}
		}
	}
	else {
		$editor = new Page("header_user", "editor");
		$editor->script("waxAlbumEditor.min.js");

		if (isset($_GET['id'])) {
			$editor->setTitle("WaXchange &bull; Editing Album #" . $_GET['id']);
			$editor->setDescription("Editing Album #" . $_GET['id'] . " on WaXchange music marketplace.");
			$alb = new Album(intval($_GET['id']));
			$alb->read();

			if (strcmp($alb->getSeller(), $_SESSION['current_user']) != 0) {
				$editor->error("<h2>You can not edit an album that you did not post.</h2>");
				exit();
			}

			$editor->hreplace("USERID", $alb->getSellerId());
			$editor->replacea([
				"ALBUM_TITLE" => $alb->getTitle(),
				"ALBUM_MEDIA" => $alb->getMedia(),
				"ALBUM_ARTIST" => $alb->getArtist(),
				"ALBUM_BUYER" => $alb->getBuyer(),
				"ALBUM_LABEL" => $alb->getLabel(),
				"ALBUM_POSTED" => $alb->getPosted(),
				"ALBUM_IMAGE" => $alb->getImage(),
				"ALBUM_COUNTRY" => $alb->country,
				"ALBUM_CURRENCY" => $alb->getCurrency(),
				"ALBUM_COND" => $alb->getCond(),
				"M_SELECT" => ((strcmp($alb->getCond(), "m") == 0) ? "selected" : ""),
				"NM_SELECT" => ((strcmp($alb->getCond(), "nm") == 0) ? "selected" : ""),
				"VG_SELECT" => ((strcmp($alb->getCond(), "vg") == 0) ? "selected" : ""),
				"G_SELECT" => ((strcmp($alb->getCond(), "g") == 0) ? "selected" : ""),
				"F_SELECT" => ((strcmp($alb->getCond(), "f") == 0) ? "selected" : ""),
				"P_SELECT" => ((strcmp($alb->getCond(), "p") == 0) ? "selected" : ""),
				"ALBUM_PURCHASED" => $alb->getPurchased(),
				"USERNAME" => $_SESSION['current_user'],
				"USERID" => $alb->getSellerId(),
				"EDITMODE" => "edit",
				"VINYL_SELECT" => ((strcmp($alb->getMedia(), "Vinyl") == 0) ? "selected" : ""),
				"CASSETTE_SELECT" => ((strcmp($alb->getMedia(), "Cassette") == 0) ? "selected" : ""),
				"CD_SELECT" => ((strcmp($alb->getMedia(), "CD") == 0) ? "selected" : ""),
				"EDITING" => "Editing <i>" . $alb->getTitle() . "</i>"
			]);

			$editor->setContent(str_replace("\"{{ALBUM_ID}}\"", "" . $alb->getId(), $editor->getContent()));
			$editor->setContent(str_replace("\"{{ALBUM_YEAR}}\"", "" . $alb->getYear(), $editor->getContent()));
			$editor->setContent(str_replace("\"{{SELLERID}}\"", "" . $alb->getSellerId(), $editor->getContent()));
			$editor->setContent(str_replace("\"{{BUYERID}}\"", "" . $alb->getBuyerId(), $editor->getContent()));
			$editor->setContent(str_replace("\"{{ALBUM_DISCS}}\"", "" . $alb->getDiscs(), $editor->getContent()));
			$editor->setContent(str_replace("\"{{ALBUM_PRICE}}\"", "" . $alb->price, $editor->getContent()));
			$editor->setContent(str_replace("\"{{UPLOADED}}\"", "true", $editor->getContent()));
			
			$tl = "[";
			$t = 0;
			foreach ($alb->getTracklist() as $track) {
				$comma = (($t > 0) ? "," : "");
				
				$tl .= <<<EOF
		{$comma}{
			title: "{$track[0]}",
			length: "{$track[1]}"
		}
EOF;
				$t++;
			}
			$tl .= "]";
			$editor->setContent(str_replace("\"{{ALBUM_TRACKLIST}}\"", $tl, $editor->getContent()));
			$editor->setContent(str_replace("\"{{NUMBER_OF_TRACKS}}\"", "" . $t, $editor->getContent()));
		}
		else {
			$editor->setTitle("WaXchange &bull; New Album");
			$editor->setDescription("Uploading new album to WaXchange music marketplace.");
			$uid = Methods::getIdFromName($_SESSION['current_user']);

			$editor->hreplace("USERID", $uid);
			$editor->replacea([
				"ALBUM_TITLE" => "",
				"ALBUM_MEDIA" => "",
				"ALBUM_ARTIST" => "",
				"ALBUM_BUYER" => "",
				"ALBUM_LABEL" => "",
				"ALBUM_POSTED" => "",
				"ALBUM_IMAGE" => "",
				"ALBUM_COUNTRY" => "",
				"ALBUM_YEAR" => "",
				"ALBUM_CURRENCY" => "",
				"ALBUM_COND" => "",
				"M_SELECT" => "",
				"NM_SELECT" => "",
				"VG_SELECT" => "",
				"G_SELECT" => "",
				"F_SELECT" => "",
				"P_SELECT" => "",
				"BUYERID" => "",
				"ALBUM_PURCHASED" => "",
				"USERNAME" => $_SESSION['current_user'],
				"USERID" => $uid,
				"EDITMODE" => "new",
				"VINYL_SELECT" => "",
				"CASSETTE_SELECT" => "",
				"CD_SELECT" => "",
				"EDITING" => "Posting New Release"
			]);

			$editor->setContent(str_replace("\"{{ALBUM_ID}}\"", "0", $editor->getContent()));
			$editor->setContent(str_replace("\"{{ALBUM_DISCS}}\"", "1", $editor->getContent()));
			$editor->setContent(str_replace("\"{{ALBUM_PRICE}}\"", "5.99", $editor->getContent()));
			$editor->setContent(str_replace("\"{{UPLOADED}}\"", "false", $editor->getContent()));
			$editor->setContent(str_replace("\"{{SELLERID}}\"", $uid, $editor->getContent()));
			$tl = <<<EOF
		[
			{
				title: "Track One",
				length: "1:00"
			},
			{
				title: "Track Two",
				length: "1:00"
			}
		]
EOF;
			$editor->setContent(str_replace("\"{{ALBUM_TRACKLIST}}\"", $tl, $editor->getContent()));
			$editor->setContent(str_replace("\"{{NUMBER_OF_TRACKS}}\"", "2", $editor->getContent()));
		}
		$editor->output();
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
