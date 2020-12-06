<?php
/*
	index.php

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");

$home = new Page(((isset($_SESSION['current_user'])) ? "header_user" : "header_guest"), "index");
$home->setTitle("WaXchange &bull; Dashboard");
$home->setDescription("WaXchange is a music marketplace, where users can buy and sell albums.");

if (isset($_SESSION['current_user'])) {
	$userid = Methods::getIdFromName($_SESSION['current_user']);
	$home->hreplace("USERID", $userid);
	$home->replacea([
		"USERID" => $userid,
		"USERNAME" => $_SESSION['current_user']
	]);

	$home->setContent(Methods::snip("{{IF_NOT_LOGGED_IN}}", "{{ENDNIF}}", $home->getContent()));
	$home->replace("IF_LOGGED_IN");
	$home->replace("ENDIF");
}
else {
	$home->setContent(Methods::snip("{{IF_LOGGED_IN}}", "{{ENDIF}}", $home->getContent()));
	$home->replace("IF_NOT_LOGGED_IN");
	$home->replace("ENDNIF");
}

$home->output();
