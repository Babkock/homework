<?php
/* HOMEWORK
 *
 *      /homework/index
 *
 * Copyright (c) 2017-2020 Tanner Babcock.
*/
namespace TBcom;
require_once("../resources/lib/TBcom.php");
require_once("../resources/lib/Log.php");

$hw = new Build\Page("homework.header", "homework.index", "homework.footer");
$hw->init("Tanner Babcock Homework", "Homework assignments for Tanner Babcock.", Codes\Portfolio);

$hw->middle->replace("EMAIL", "tababcock@dmacc.edu");

$hw->output();

