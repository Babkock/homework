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
