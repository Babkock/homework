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
		if ((!isset($_POST['showemail'])) && (!isset($_POST['biography'])) && (!isset($_FILES['image']))) {
			exit("<p class=\"error\">You did not make any changes.</p>");
		}
		$user = new User();
		$uid = Methods::getIdFromName($_SESSION['current_user']);
		$user->read($uid);

		if (isset($_POST['showemail'])) {
			if ($user->getShowEmail() != intval($_POST['showemail']))
				$user->setShowEmail(intval($_POST['showemail']));
		}
		if (isset($_POST['biography'])) {
			if (strcmp($user->getBiography(), $_POST['biography']) != 0)
				$user->setBiography(substr($_POST['biography'], 0, 600));
		}

		if ((isset($_FILES['image'])) && ($_FILES['image']['error'] == 0)) {
			$filetype = $_FILES['image']['type'];
			$filename = "img/user/" . $_SESSION['current_user'] . $filetype;			
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
				if (file_exists(__DIR__ . "/" . $filename)) {
					unlink(__DIR__ . "/" . $filename);
					move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/" . $filename);
				}
				else {
					// the "img/album/" should already be in $json->image
					move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/" . $filename);
				}
				$user->setImage($filename);
			}
		}
		$user->update();

		if (isset($_FILES['image']))
			exit("<p class=\"success\">Your new avatar was uploaded, and your changes were saved.</p>");
		else
			exit("<p class=\"success\">Your changes were saved.</p>");
	}
	else {
		$settings = new Page("header_user", "settings");
		$settings->script("waxSettings.min.js");
		$settings->setTitle("WaXchange &bull; Settings");
		$settings->setDescription("This page lets you change your user preferences. This page is different for everyone.");

		$uid = Methods::getIdFromName($_SESSION['current_user']);

		$settings->hreplace("USERID", $uid);

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
		$settings->replacea([
			"BIOGRAPHY" => $row['biography'],
			"USERIMG" => $row['image'] ?? "img/user/default.jpg"
		]);
		*/

		$settings->output();
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
