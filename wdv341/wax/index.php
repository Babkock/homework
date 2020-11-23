<?php
/*
	index.php

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");

$home = new Page("index");
$home->setTitle("WaXchange &bull; Home");
$home->setDescription("WaXchange is a music marketplace, where users can buy and sell albums.");

if ($_SESSION['valid_user'] === true) {
	$userid = Methods::getIdFromName($_SESSION['current_user']);
	$home->replace("USERID", "" . $userid);
}

$home->output();

