<?php
/*
	register.php

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");

if (isset($_SESSION['current_user']))
	header("Location: index");

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
			$ch = $db->prepare("SELECT `id` FROM `users` WHERE `username`=:username LIMIT 1");
			$ch->bindParam(":username", $_POST['username']);
			$ch->execute();

			$r = $ch->fetch(PDO::FETCH_ASSOC);
			if ($r) {
				exit("<p class=\"error\">That username is taken by someone else. Please choose another name.</p>");
			}

			$user = new User();
			$user->seta([
				"username" => $_POST['username'],
				"password" => hash("sha256", $_POST['password']),
				"email" => $_POST['email'],
				"country" => $_POST['country']
			]);

			$user->write();

			$to = $_POST['email'];
			$subject = "Welcome to WaXchange!";
			$message = "<h1>Welcome to WaXchange music marketplace!</h1>";
			$message .= "<h2>Your username: " . $_POST['username'] . "</h2>";
			$message .= "<p>We're just so happy you decided to join our music marketplace. You're now ready to start buying and selling albums with other users.</p>";

			$header = "From:tanner@tannerbabcock.com \r\n";
			$header .= "Cc:tanner.a.babcock@gmail.com \r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html\r\n";

			mail($to, $subject, $message, $header);

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
