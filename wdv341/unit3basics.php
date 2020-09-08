<!DOCTYPE html>
<!--
	Unit 3: PHP Basics
	Tanner Babcock
	September 1, 2020
-->
<html lang="en">
<head>
	<title>Unit 3: PHP Basics</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
	<?php
	$yourName = "Tanner Babcock";
	?>
	<h1>Unit 3: PHP Basics</h1>
	<h2><?php echo $yourName; ?></h2>
	<?php
	$number1 = 10;
	$number2 = 22;
	$total = $number1 + $number2;
	?>
	<div class="box">
		<ul>
			<li>number1 = <?php echo "".$number1; ?></li>
			<li>number2 = <?php echo "".$number2; ?></li>
			<li>total = <?php echo "".$total; ?></li>
		</ul>
		<p>Here is my languages array:</p>
		<script>
			<?php
			echo "var langs = ['HTML', 'PHP', 'Javascript'];\n\n";
			echo "for (var i = 0; i < langs.length; i++) {\n";
			echo "\tdocument.write(i + ': ' + langs[i] + '<br />');\n";
			echo "}\n";
			?>
		</script>
	</div>
	<center>
		<p>
			<a href="/homework/index">&rarr; Return to WDV341 Homework &larr;</a> &bull;
			 <a href="https://github.com/Babkock/homework/blob/master/wdv341/unit3basics.php" target="_blank">View Source Code</a>
		</p>
	</center>
</body>
</html>