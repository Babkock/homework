<?php
/*
	album.php

	WaXchange PHP Project
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
					"price" => $json->price,
					"seller" => $json->seller,
					"buyer" => $json->buyer,
					"image" => $json->image,
					"label" => $json->label,
					"posted" => $json->posted,
					"tracklist" => $tl
				]);

				$album->update();

				exit("<p class=\"success\">Your changes to this album were saved. <a href=\"album?id=" . $_GET['id'] . "\">View it here.</a></p>");
			}
			else {
				$album = new Album();
				$json = json_decode($_POST['albumJson']);

				if ((isset($_FILES['image'])) && ($_FILES['image']['error'] == 0)) {
					$filename = $json->image;
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

						if (file_exists(__DIR__ . "/img/" . $filename)) {
							exit("<p class=\"error\">Filename already exists. Please choose a different name.</p>");
						}
						else {
							move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/img/" . $filename);
						}
					}
				}
				$tl = json_encode($json->tracklist);

				$album->seta([
					"artist" => $json->artist,
					"title" => $json->title,
					"media" => $json->media,
					"discs" => $json->discs,
					"price" => $json->price,
					"seller" => $json->seller,
					"buyer" => $json->buyer,
					"image" => $json->image,
					"label" => $json->label,
					"posted" => $json->posted,
					"tracklist" => $tl
				]);

				$album->write();

				exit("<p class=\"success\">Your album was uploaded successfully!</p>");
			}
		}
	}
	else {
		$editor = new Page("album_editor");
		$editor->setTitle("WaXchange &bull; Editing Album");
		// more here...
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}