<?php
/*
	Unit 13: Login and Protected Pages
	November 13, 2020
	Tanner Babcock
*/
session_start();

session_destroy();

header('Location: login');

