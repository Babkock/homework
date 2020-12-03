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

	}
	else {
		$settings = new Page("header_user", "settings");
		$settings->setTitle("WaXchange &bull; Settings");
		$settings->setDescription("This page lets you change your user preferences. This page is different for everyone.");
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
