<?php
/* HOMEWORK
 *
 *      /homework/index
 *
 * Copyright (c) 2017-2021 Tanner Babcock.
*/
namespace TBcom;
require_once("../resources/lib/TBcom.php");
require_once("../resources/lib/Log.php");

$hw = new Build\Page("homework.header", "homework.index", "homework.footer");
$hw->init("Tanner Babcock Fall 2020", "Homework assignments for Tanner Babcock.", Codes\Portfolio);

$hw->middle->replace("EMAIL", "tababcock@dmacc.edu");

$hw->output();

