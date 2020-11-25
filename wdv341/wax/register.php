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

	}
	else {
		$register = new Page("register");
		$register->setTitle("WaXchange &bull; Register");
		$register->setDescription("Register for the WaXchange music marketplace.");
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
