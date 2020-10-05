<?php
/*
	Unit 8: PHP Formatted Content
	October 4, 2020
	Tanner Babcock
*/
try {
	require_once("dbConnect.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Unit 8: PHP Formatted Content</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="icon" type="image/png" href="/images/favicon.png" />
</head>
<body>
	<h1>WDV341 Intro PHP</h1>
	<h2>Example Code - Display Events as formatted output blocks</h2>   
	<h3><?php
		$st1 = $db->prepare("SELECT `event_date` FROM `wdv341_events`");
		$st1->execute();
		$total = 0;

		while ($row = $st1->fetch(PDO::FETCH_NUM)) {
			$evday = date("d-m-Y", strtotime($row[0]));
			$day = date("d-m-Y", mktime());

			if (strcmp($evday, $day) == 0) {
				$total++;
			}
		}
		echo $total;
	?> Events are available today.</h3>

	<div class="eventBlock">
		<div>
			<p><b>Event Name and Presenter</b></p>
		</div>
		<div>
			<p><b>Description</b></p>
		</div>
		<div>
			<p><b>Time</b></p>
		</div>
		<div>
			<p><b>Date</b></p>
		</div>
	</div>

<?php
	$st2 = $db->prepare("SELECT `event_id`, `event_name`, `event_description`, `event_presenter`, DATE_FORMAT(`event_date`, '%a %M %D, %Y'), `event_time` FROM `wdv341_events` ORDER BY `event_id` DESC");
	$st2->execute();

	while ($row = $st2->fetch(PDO::FETCH_BOTH)) {
?>
		<div class="eventBlock">
			<div>
				<span class="displayEvent">Event: <?php
				$evmonth = date("m-Y", strtotime($row[4]));
				$month = date("m-Y", mktime());

				if (strcmp($evmonth, $month) == 0) {
					if (time() < strtotime($row[4])) {
						echo "<span class=\"soon\"><i>{$row['event_name']}</i></span>";
					}
					else {
						echo "<span class=\"soon\">{$row['event_name']}</span>";
					}
				} else {
					if (time() < strtotime($row[4])) {
						echo "<i>{$row['event_name']}</i>";
					} else {
						echo $row['event_name'];
					}
				}
				
				?></span><br />
				<span>with <b><?php echo $row['event_presenter']; ?></b></span>
			</div>
			<div>
				<span class="displayDescription"><?php echo $row['event_description']; ?></span>
			</div>
			<div>
				<span class="displayTime"><?php
				$t = date('h:i A', strtotime($row['event_time']));
				echo $t;
				?></span>
			</div>
			<div>
				<span class="displayDate"><?php echo $row[4]; ?></span>
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
	<p><a href="/homework/wdv341/selectEvents" alt="Previous assignment" title="Previous assignment">Unit 7: Create selectEvents.php</a></p>
	<p><a href="/homework/index">&rarr; Return to WDV341 Homework &larr;</a> &bull; <a href="https://github.com/Babkock/homework/blob/master/wdv341/formatEvents.php" target="_blank">View Source Code</a></p>
</footer>
</body>
</html>