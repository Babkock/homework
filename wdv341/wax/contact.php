<?php
/*
	contact.php

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");

$to = "babkock@gmail.com";
$subject = "This is a test Email";

$message = "<h1>Hello World!</h1>";
$message .= "<b>I hope I can see this email in my inbox!</b>";

$header = "From:tanner@tannerbabcock.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";

$ret = mail($to, $subject, $message, $header);

if ($ret == true) {
	exit("<p>Mail sent successfully!</p>");
}
else {
	exit("<p>Mail could not be sent. Probably because you're garbage.</p>");
}

/*
try {
	if (!empty($_POST)) {
		if ((empty($_POST['fullname'])) || (empty($_POST['email'])) || (empty($_POST['subject'])) || (empty($_POST['message']))) {
			exit("<p class=\"error\">One or more fields are empty.</p>");
		}
		// email code here
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
*/
