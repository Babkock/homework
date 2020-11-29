<?php
/*
	logout.php

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
session_start();

$_SESSION = [];
session_destroy();

header("Location: index");
