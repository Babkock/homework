<?php
/*
	browse.php

	WaXchange PHP Project
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");

try {
	if (!empty($_POST)) {
		/* ajax responder */

	}
	else {
		/* show a normal page */
		if (!isset($_SESSION['current_user'])) {
			$browse = new Page("header_guest", "browse");
			$browse->setTitle("WaXchange &bull; Browsing Releases");
		}
		else {
			$browse = new Page("header_user", "browse");
			$browse->setTitle("WaXchange &bull; Browsing Releases");
		}
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}