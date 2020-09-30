<?php
/*
	Unit 8: PHP Formatted Content
	October 1, 2020
	Tanner Babcock
*/
try {
	require_once("dbConnect.php");

	$res = $db->query("SELECT `event_id`, `event_name`, `event_description`, `event_presenter`, DATE_FORMAT(`event_date`, '%a %M %D, %Y'), `event_time` FROM `wdv341_events` SORT BY `event_id` DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>WDV341 Intro PHP  - Display Events Example</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="icon" type="image/png" href="/images/favicon.png" />
</head>
<body>
	<h1>WDV341 Intro PHP</h1>
	<h2>Example Code - Display Events as formatted output blocks</h2>   
	<h3>??? Events are available today.</h3>
<?php
	foreach ($res as $row) {
?>
		<div class="eventBlock">	
			<div>
				<span class="displayEvent">Event: <?php
				if (strtotime($row[4]) < strtotime("+1 month")) {
					if (strtotime($row[4]) > strtotime("now")) {
						echo "<span class=\"soon\"><i>{$row[1]}</i></span>";
					}
					else {
						echo "<span class=\"soon\">{$row[1]}</span>";
					}
				}
				else {
					if (strtotime($row[4]) > strtotime("now")) {
						echo "<i>{$row[1]}</i>";
					}
					else {
						echo $row[1];
					}
				}
				?></span>
				<span>Presenter: <?php echo $row[3]; ?></span>
			</div>
			<div>
				<span class="displayDescription">Description: <?php echo $row[2]; ?></span>
			</div>
			<div>
				<span class="displayTime">Time: <?php echo $row[5]; ?></span>
			</div>
			<div>
				<span class="displayDate">Date: <?php echo $row[4]; ?></span>
			</div>
		</div>
<?php
	}
	$db = null;
}
catch (PDOException $e) {
	echo("<b class=\"error\">Error: {$e->getMessage()}</b>");
}
?>
</div>
<footer>
	<p><a href="/homework/index">&rarr; Return to WDV341 Homework &larr;</a> &bull; <a href="https://github.com/Babkock/homework/blob/master/wdv341/formatEvents.php" target="_blank">View Source Code</a></p>
</footer>
</body>
</html>