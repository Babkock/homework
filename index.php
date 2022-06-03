<?php
/*
 * HOMEWORK
 *
 *      /homework/index
 *
 * Copyright (c) 2017-2021 Tanner Babcock.
*/
namespace TBcom;
require_once("../resources/lib/TBcom.php");
require_once("../resources/lib/Log.php");

$hw = new Build\Page("homework.header", "homework.index", "homework.footer");
$hw->init("Tanner Babcock {{CLASS}}", "Homework assignments {{CLASS2}} for Tanner Babcock.", Codes\Portfolio);

$hw->middle->replace("EMAIL", "tababcock@dmacc.edu");

if (isset($_GET['c'])) {
	switch ($_GET['c']) {
		case "wdv341":
			$hw->middle->replace("WDV341_SELECT", "display:inline");
			$hw->middle->replacea([
				"DEFAULT_SELECT" => "display:none",
				"WDV321_SELECT" => "display:none",
				"WDV221_SELECT" => "display:none",
				"WDV205_SELECT" => "display:none",
				"WDV131_SELECT" => "display:none",
				"WDV101_SELECT" => "display:none"
			]);
			$hw->header->replace("CLASS", "Intro to PHP");
			$hw->header->replace("CLASS2", "for Intro to PHP");
			break;
		case "wdv321":
			$hw->middle->replace("WDV321_SELECT", "display:inline");
			$hw->middle->replacea([
				"DEFAULT_SELECT" => "display:none",
				"WDV341_SELECT" => "display:none",
				"WDV221_SELECT" => "display:none",
				"WDV205_SELECT" => "display:none",
				"WDV131_SELECT" => "display:none",
				"WDV101_SELECT" => "display:none"
			]);
			$hw->header->replace("CLASS", "Advanced JavaScript");
			$hw->header->replace("CLASS2", "for Advanced JavaScript");
			break;
		case "wdv221":
			$hw->middle->replace("WDV221_SELECT", "display:inline");
			$hw->middle->replacea([
				"DEFAULT_SELECT" => "display:none",
				"WDV341_SELECT" => "display:none",
				"WDV321_SELECT" => "display:none",
				"WDV205_SELECT" => "display:none",
				"WDV131_SELECT" => "display:none",
				"WDV101_SELECT" => "display:none"
			]);
			$hw->header->replace("CLASS", "Intro to JavaScript");
			$hw->header->replace("CLASS2", "for Intro to JavaScript");
			break;
		case "wdv205":
			$hw->middle->replace("WDV205_SELECT", "display:inline");
			$hw->middle->replacea([
				"DEFAULT_SELECT" => "display:none",
				"WDV341_SELECT" => "display:none",
				"WDV321_SELECT" => "display:none",
				"WDV221_SELECT" => "display:none",
				"WDV131_SELECT" => "display:none",
				"WDV101_SELECT" => "display:none"
			]);
			$hw->header->replace("CLASS", "Advanced CSS");
			$hw->header->replace("CLASS2", "for Advanced CSS");
			break;
		case "wdv131":
			$hw->middle->replace("WDV131_SELECT", "display:inline");
			$hw->middle->replacea([
				"DEFAULT_SELECT" => "display:none",
				"WDV341_SELECT" => "display:none",
				"WDV321_SELECT" => "display:none",
				"WDV221_SELECT" => "display:none",
				"WDV205_SELECT" => "display:none",
				"WDV101_SELECT" => "display:none"
			]);
			$hw->header->replace("CLASS", "Intro to Photoshop and Fireworks");
			$hw->header->replace("CLASS2");
			break;
		case "wdv101":
			$hw->middle->replace("WDV101_SELECT", "display:inline");
			$hw->middle->replacea([
				"DEFAULT_SELECT" => "display:none",
				"WDV341_SELECT" => "display:none",
				"WDV321_SELECT" => "display:none",
				"WDV221_SELECT" => "display:none",
				"WDV205_SELECT" => "display:none",
				"WDV131_SELECT" => "display:none"
			]);
			$hw->header->replace("CLASS", "Intro to HTML and CSS");
			$hw->header->replace("CLASS2", "for Intro to HTML and CSS");
			break;
		default:
			$hw->header->append("<center><p class=\"error\">There is no class by that name.</p></center>");
			$hw->middle->replacea([
				"DEFAULT_SELECT" => "display:inline",
				"WDV341_SELECT" => "display:none",
				"WDV321_SELECT" => "display:none",
				"WDV221_SELECT" => "display:none",
				"WDV205_SELECT" => "display:none",
				"WDV131_SELECT" => "display:none",
				"WDV101_SELECT" => "display:none"
			]);
			$hw->header->replace("CLASS", "Invalid Class");
			$hw->header->replace("CLASS2");
			break;
	}
}
else {
	$hw->middle->replacea([
		"WDV341_SELECT" => "display:none",
		"WDV321_SELECT" => "display:none",
		"WDV221_SELECT" => "display:none",
		"WDV205_SELECT" => "display:none",
		"WDV131_SELECT" => "display:none",
		"WDV101_SELECT" => "display:none"
	]);
	$hw->header->replace("CLASS", "Fall 2020");
	$hw->header->replace("CLASS2");
}

$hw->output();

