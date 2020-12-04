<?php
/*
	about.php

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");

if (isset($_SESSION['current_user'])) {
	$about = new Page("header_user", "about");
	$about->setTitle("WaXchange &bull; About");
	$about->setDescription("WaXchange is a music marketplace and community where artists and music lovers can support each other, and exchange music.");

	$uid = Methods::getIdFromName($_SESSION['current_user']);
	$about->hreplace("USERID", $uid);

	$about->output();
}
else {
	$about = new Page("header_guest", "about");
	$about->setTitle("WaXchange &bull; About");
	$about->setDescription("WaXchange is a music marketplace and community where artists and music lovers can support each other, and exchange music.");

	$about->output();	
}
