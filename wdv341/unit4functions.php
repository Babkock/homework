<!DOCTYPE html>
<!--
	Unit 4: PHP Functions
	Tanner Babcock
	September 8, 2020
-->
<html lang="en">
<head>
	<title>Unit 4: PHP Functions</title>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="/images/favicon.png" />
	<link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
<?php

function dateToString($d) {
	return date("m-d-Y", $d);
}

function intDateToString($d) {
	return date("d-m-Y", $d);
}

function checkString($str) {
	?>
	<p>Number of characters: 
	<?php echo "".strlen($str);
	$s = trim($str);
	?>
	</p>
	<p>
	Lowercase string: <b>
	<?php echo strtolower($str); ?>
	</b></p>
	<p>This string 
	<?php
	echo ((strpos($str, "DMACC") !== false) ? "does" : "does not"); ?>
	contain the string "DMACC".</p><?php
}

function numFormat($n) {
	?>
	<p>Formatted number: 
	<?php echo number_format($n); ?>
	</p><?php
}

function cashFormat($m) {
	?>
	<p>Amount of money: <b>$
	<?php echo number_format($m, 2); ?>
	</b></p><?php
}

?>
	<h1>Today is <?php echo date("l, F d Y", mktime()); ?></h1>
	<h2><?php echo dateToString(mktime()); ?></h2>
	<h3><?php echo intDateToString(mktime()); ?></h3>
	<br />

	<h2>We will now start checking strings.</h2>
	<div class="box">
		<p>The first string is "  Trout Mask Replica".</p>
		<?php checkString("  Trout Mask Replica"); ?>
		<p>The next string we will send through is "TannerDMACC".</p>
		<?php
		checkString("TannerDMACC");

		numFormat(1234567890);

		cashFormat(123456);
		?>
	</div>
	<br />
	<center>
		<p>
			<a href="/homework/index">&rarr; Return to WDV341 Homework &larr;</a> &bull;
			 <a href="https://github.com/Babkock/homework/blob/master/wdv341/unit4functions.php" target="_blank">View Source Code</a>
		</p>
	</center>
</body>
</html>
