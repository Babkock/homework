<?php
/*
	contact.php

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");

try {
	if (!empty($_POST)) {
		if ((empty($_POST['fullname'])) || (empty($_POST['email'])) || (empty($_POST['subject'])) || (empty($_POST['message']))) {
			exit("<p class=\"error\">One or more fields are empty.</p>");
		}
		else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			exit("<p class=\"error\">The email address is invalid.</p>");
		}
		else {
			$to = "tanner.a.babcock@gmail.com";
			$subject = "WaXchange Message: " . $_POST['subject'];
			$message = "<h1>" . $_POST['subject'] . "</h1>";
			$message .= "<h2>From <a href=\"mailto:" . $_POST['email'] . "\">" . $_POST['fullname'] . "</a></h2>";
			$message .= "<p>" . $_POST['message'] . "</p>";
			$message .= "<br /><br /><p><i>This message was sent through the WaXchange contact form.</i></p>";

			$header = "From:tanner@tannerbabcock.com \r\n";
			$header .= "Cc:" . $_POST['email'] . " \r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html\r\n";


			if (mail($to, $subject, $message, $header) == true) {
				exit("<p class=\"success\">Your message has been sent successfully. A copy has been sent to you.</p>");
			}
			else {
				exit("<p class=\"error\">Your message could not be delivered. Sorry.</p>");
			}
		}
	}
	else {
		if (isset($_SESSION['current_user'])) {
			$contact = new Page("header_user", "contact");
			$uid = Methods::getIdFromName($_SESSION['current_user']);
			$contact->hreplace("USERID", $uid);
		}
		else {
			$contact = new Page("header_guest", "contact");
		}
		$contact->setTitle("WaXchange &bull; Contact");
		$contact->setDescription("Use this form to contact WaXchange staff.");
		$contact->ogImage("https://tannerbabcock.com/homework/wdv341/wax/img/bigbg.jpg");
		$contact->output();
	}
}
catch (PDOException $ex) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
