<?php
/*
	Unit 12: SQL INSERT
	November 12, 2020
	Tanner Babcock
*/
require_once("dbConnect.php");

try {
	if ($_SESSION['valid_user'] == true) {
		$st = $db->prepare("SELECT * FROM `wdv341_events`");
		$st->execute();

		$eventCount = 0;
		while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$eventCount++;
		}
		$eventCount++;
?>
<!DOCTYPE html>
<!--
	Unit 12: SQL INSERT
	November 12, 2020
	Tanner Babcock
-->
<html lang="en">
	<head>
		<title>WDV341 SQL INSERT</title>
		<meta charset="utf-8" />
		<meta name="description" content="WDV341 Intro to PHP Unit 12: SQL INSERT" />
		<link rel="stylesheet" href="/homework/assets/css/style.css" />
		<link rel="icon" href="/images/favicon.png" />
	</head>
	<body>
		<header>
			<h1>WDV341 SQL INSERT</h1>
			<h2>Welcome, <?php echo $_SESSION['current_user']; ?></h2>
			<nav>
				<ul>
					<li><a href="login">Admin Home</a></li>
					<li><a href="eventsForm">New Event</a></li>
					<li><a href="eventsList">Show All Events</a></li>
					<li><a href="logout">Logout</a></li>
				</ul>
			</nav>
		</header>
		<main id="events-form">
			<form action="insertEvents" method="post" enctype="multipart/form-data">
				<h2>Creating New Event</h2>
				<div class="formFlex">
					<label for="event_id">Event ID:</label>
					<input type="number" name="event_id" value="<?php echo $eventCount; ?>" title="ID of the event. Should be auto-generated" alt="ID of the event. Should be auto-generated" />
				</div>
				<div class="formFlex">
					<label for="event_name">Event Name:</label>
					<input type="text" name="event_name" title="Name of the event" alt="Name of the event" placeholder="The Big Big Event" />
				</div>
				<div class="formFlex">
					<label for="event_presenter">Event Presenter:</label>
					<input type="text" name="event_presenter" title="Who is presenting this event?" alt="Who is presenting this event?" placeholder="Mr. Man" />
				</div>
				<div class="formFlex">
					<label for="event_date">Event Date (<i>in the format YYYY-MM-DD</i>):</label>
					<input type="text" name="event_date" maxlength="10" title="When does this event take place?" alt="When does this event take place?" placeholder="YYYY-MM-DD" />
				</div>
				<div class="formFlex">
					<label for="event_time">Event Time (<i>in the format HH:MM:SS</i>):</label>
					<input type="text" name="event_time" maxlength="8" size="9" title="What time does this event start?" alt="What time does this event start?" placeholder="HH:MM:SS" />
				</div>
				<center>
					<label for="event_description"><b>Event Description:</b></label>
					<textarea name="event_description" cols="40" rows="3" title="Enter the description for this event" alt="Enter the description for this event" placeholder="Wow we got some good stuff at this one!"></textarea>
				</center>
				<div class="buttons">
					<input type="submit" value="Submit" name="submit" /> &bull;
					<input type="reset" value="Reset" />
				</div>
			</form>
		</main>
		<footer>
			<p><a href="/homework/index?c=wdv341">&rarr; Return to WDV341 Homework &larr;</a> &bull; <a href="https://github.com/Babkock/homework/blob/master/wdv341/eventsForm.php" target="_blank" title="GitHub" alt="GitHub">View Source Code</a></p>
		</footer>
	</body>
</html>
<?php
	}
	else {
		header('Location: login');
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
