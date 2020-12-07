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
		$uid = Methods::getIdFromName($_SESSION['current_user']);
		$user = new User(intval($uid));
		$user->read();

		/*
		if (isset($_POST['showemail'])) {
			switch ($_POST['showemail']) {
				case "one":
					$user->setShowEmail(1);
					break;
				case "two":
					$user->setShowEmail(2);
					break;
				case "three":
					$user->setShowEmail(3);
					break;
			}
		}
		if (isset($_POST['biography'])) {
			$user->setBiography(substr($_POST['biography'], 0, 600));
		}
		if (isset($_POST['country'])) {
			if (strlen($_POST['country']) > 1)
				$user->setCountry($_POST['country']);
		} */
		$user->seta($_POST);

		if ((isset($_FILES['image'])) && ($_FILES['image']['error'] == 0)) {
			$filetype = $_FILES['image']['type'];
			$oldname = $_FILES['image']['name'];
			$ext = pathinfo($oldname, PATHINFO_EXTENSION);
			$filename = "img/user/" . $_SESSION['current_user'] . "." . $ext;
			$filesize = $_FILES['image']['size'];

			$validtypes = [
				"jpg" => "image/jpg",
				"jpeg" => "image/jpeg",
				"png" => "image/png",
				"gif" => "image/gif"
			];

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

		$country = Methods::countryExpand($row['country']);

		switch (intval($row['showemail'])) {
			case 1:
				$settings->replacea([
					"HIDE_SELECT" => "selected",
					"ABSTRACT_SELECT" => "",
					"SHOW_SELECT" => "",
					"SHOWEMAIL" => "one"
				]);
				break;
			case 2:
				$settings->replacea([
					"HIDE_SELECT" => "",
					"ABSTRACT_SELECT" => "selected",
					"SHOW_SELECT" => "",
					"SHOWEMAIL" => "two"
				]);
				break;
			case 3:
				$settings->replacea([
					"HIDE_SELECT" => "",
					"ABSTRACT_SELECT" => "",
					"SHOW_SELECT" => "selected",
					"SHOWEMAIL" => "three"
				]);
				break;
		}
		$settings->replacea([
			"USERID" => $uid,
			"BIOGRAPHY" => addslashes($row['biography']),
			"USERIMG" => $row['image'] ?? "img/user/default.jpg",
			"COUNTRY" => $row['country'],
			"USER_COUNTRY" => $country
		]);

		$settings->output();
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
