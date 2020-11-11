<?php
/*
	Unit 7: Create selectEvents.php
	September 29, 2020
	Tanner Babcock
*/
require_once("dbConnect.php");
try {
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
	<h3>Database: tababcock_wdv341</h3>
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

	while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
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
		<p>
			<a href="/homework/wdv341/unit5files" alt="Previous assignment" title="Previous assignment">Unit 5: File Upload</a> &bull; <a href="/homework/wdv341/retailProducts" alt="Next assignment" title="Next assignment">Unit 8: PHP Formatted Content</a>
		</p>
		<p><a href="/homework/index">&rarr; Return to WDV341 Homework &larr;</a> &bull; <a href="https://github.com/Babkock/homework/blob/master/wdv341/selectEvents.php" target="_blank" alt="GitHub" title="GitHub">View Source Code</a></p>
	</footer><?php
}
catch (PDOException $e) {
	echo "<b class=\"error\">{$e->getMessage()}</b><br />";
}
finally {
	?>
</body>
</html>
	<?php
	$db = null;
}
