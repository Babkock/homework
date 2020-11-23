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

if (isset($_SESSION['current_user'])) {
	$userid = Methods::getIdFromName($_SESSION['current_user']);
	$home->replace("USERID", "" . $userid);

	$home->setContent(Methods::snip("{{IF_NOT_LOGGED_IN}}", "{{ENDNIF}}", $home->getContent()));
	$home->replace("IF_LOGGED_IN");
	$home->replace("ENDIF");

	$home->setContent(Methods::snip("{{2IF_NOT_LOGGED_IN}}", "{{2ENDNIF}}", $home->getContent()));
	$home->replace("2IF_LOGGED_IN");
	$home->replace("2ENDIF");
}
else {
	$home->setContent(Methods::snip("{{IF_LOGGED_IN}}", "{{ENDIF}}", $home->getContent()));
	$home->replace("IF_NOT_LOGGED_IN");
	$home->replace("ENDNIF");

	$home->setContent(Methods::snip("{{2IF_LOGGED_IN}}", "{{2ENDIF}}", $home->getContent()));
	$home->replace("2IF_NOT_LOGGED_IN");
	$home->replace("2ENDNIF");
}

$home->output();
