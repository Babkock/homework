<?php
/*
	register.php

	WaXchange PHP Project
	November - December 2020
	Copyright (c) 2020 Tanner Babcock
*/
require_once("lib/waxchange.php");

try {
	if (!empty($_POST)) {
		if ((!isset($_POST['username'])) || (!isset($_POST['password'])) || (!isset($_POST['country'])) || (!isset($_POST['email']))) {
			exit("<p class=\"error\">One or more fields are empty.</p>");
		}
		else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			exit("<p class=\"error\">The email address is invalid.</p>");
		}
		else if (strcmp($_POST['password'], $_POST['password2']) != 0) {
			exit("<p class=\"error\">The two passwords do not match.</p>");
		}
		else {
			$user = new User();
			$user->seta([
				"username" => $_POST['username'],
				"password" => hash("sha256", $_POST['password']),
				"email" => $_POST['email'],
				"country" => $_POST['country']
			]);

			$user->write();

			exit("<p class=\"success\">You have successfully registered. <a href=\"login\">Log in to your new account here.</a></p>");
		}
	}
	else {
		$register = new Page("header_guest", "register");
		$register->setTitle("WaXchange &bull; Register");
		$register->setDescription("Register for the WaXchange music marketplace.");

		$register->output();
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
