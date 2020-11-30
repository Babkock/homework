<?php
/*
	buy.php

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
		$buy = new Page("header", "buy_confirm");
		$buy->setTitle("Buying {{ALBUM_TITLE}}");
		$buy->setDescription("This is the purchase confirmation page for the album {{ALBUM_ARTIST}} - {{ALBUM_TITLE}}. It costs $ {{ALBUM_PRICE}}.");
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
