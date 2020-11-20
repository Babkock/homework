<?php
/*
	index.php

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");

Methods::authorize();

$home = new Page("index");
$home->setTitle("WaXchange &bull; Home");
$home->setDescription("WaXchange is a music marketplace, where users can buy and sell albums.");
$home->output();

