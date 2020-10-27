<?php
/*
	Unit 11: Self-Posting Form and PHP Data Validation
	October 27, 2020
	Tanner Babcock
*/
session_start();

// Only allow a valid user access to this page

if ($_SESSION['validUser'] !== "yes") {
	header('Location: index.php');
}
