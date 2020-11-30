<?php
/*
	login.php

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");

if ((isset($_SESSION['current_user'])) && (strcmp($_SESSION['token'], hash("sha256", $passkey)) == 0)) {
	header('Location: index');
	exit();
}

if (!isset($_SESSION['valid_user']))
	$_SESSION['valid_user'] = false;
if (!isset($_SESSION['current_user']))
	$_SESSION['current_user'] = "";
if (!isset($_SESSION['token']))
	$_SESSION['token'] = "";

try {
	$login = new Page("header_login", "login");
	$login->setTitle("WaXchange &bull; Login");
	$login->setDescription("The login page for the WaXchange music market.");
	
	if (!empty($_POST)) {
		if ((!isset($_POST['username'])) && (!isset($_POST['password']))) {
			$login->replace("LOGINERROR", "<p class=\"error\">Error: One or more fields are empty.</p>");
			$login->replace("TRY_USERNAME");
		}
		else {
			$st = $db->prepare("SELECT * FROM `users`");
			$st->execute();

			$_SESSION['valid_user'] = false;
			while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
				if ((strcmp($row['username'], $_POST['username']) == 0) &&
					(strcmp($row['password'], hash("sha256", $_POST['password'])) == 0)) {
					$_SESSION['valid_user'] = true;
					$_SESSION['current_user'] = $_POST['username'];
					$_SESSION['token'] = hash("sha256", $passkey);
					break;
				}
			}
		}

		if ($_SESSION['valid_user'] == true) {
			header('Location: index');
			exit();
		}
		else {
			$login->replace("LOGINERROR", "<p class=\"error\">Error: Invalid username or password. Please try again.</p>");
			$login->replace("TRY_USERNAME", $_POST['username']);
		}
		$login->output();
	}
	else {
		$login->replace("LOGINERROR");
		$login->replace("TRY_USERNAME");

		$login->output();
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
