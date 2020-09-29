<?php
/*
	Unit 7: Create selectEvents.php
	September 29, 2020
	Tanner Babcock
*/
try {
	require_once("dbConnect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Unit 7: Create selectEvents.php</title>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="/images/favicon.png" />
	<link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
	<h1>Unit 7: Create selectEvents.php</h1>
	<h3>tababcock_wdv341</h3>
	<div class="box">
		<table class="js"><thead>
			<tr>
				<td><b>ID</b></td>
				<td><b>Event Name</b></td>
				<td><b>Presenter</b></td>
				<td><b>Date</b></td>
			</tr>
		</thead><tbody>
<?php
	$st = $db->prepare("SELECT * FROM `wdv341_events`");
	$st->execute();

	while ($row = $st->fetchAll()) {
		$out = <<<EOF
			<tr>
				<td>{$row['event_id']}</td>
				<td>{$row['event_name']}</td>
				<td>{$row['event_presenter']}</td>
				<td>{$row['event_date']}</td>
			</tr>
EOF;
		echo $out;
	}
	?>
		</tbody></table>
	</div>
	<p>I remembered not to commit my <b>dbConnect.php</b> file!</p>
	<footer>
		<a href="/homework/index">&rarr; Return to WDV341 Homework &larr;</a> &bull; <a href="https://github.com/Babkock/homework/blob/master/wdv341/selectEvents.php" target="_blank">View Source Code</a>
	</footer><?php
}
catch (PDOException $e) {
	echo "<b>{$e->getMessage()}</b><br />";
}
finally {
	?>
</body>
</html>
	<?php
	$db = null;
}
