<?php
/*
	Unit 11: Self-Posting Form
	November 3, 2020
	Tanner Babcock
*/
require_once("dbConnect.php");

if (empty($_POST)) {
	try {
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
	Unit 11: Self-Posting Form
	November 3, 2020
	Tanner Babcock
-->
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>WDV341 Event Form</title>
		<link rel="stylesheet" href="/homework/assets/css/style.css" />
		<link rel="icon" type="image/png" href="/images/favicon.png" />
	</head>
	<body>
		<header>
			<h1>WDV341 Event Form</h1>
			<h2>Tanner Babcock</h2>
		</header>
		<main id="events-form">
			<form action="inputEvent" method="post" enctype="multipart/form-data">
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
			<p><a href="eventForm.html" title="Previous assignment" alt="Previous assignment">Unit 11: Events Input Form</a> &bull; <a href="eventsForm" alt="Next assignment" title="Next assignment">Unit 12: SQL INSERT</a></p>
			<p><a href="/homework/index?c=wdv341">&rarr; Return to WDV341 Homework &larr;</a> &bull; <a href="https://github.com/Babkock/homework/blob/master/wdv341/inputEvent.php" target="_blank" title="GitHub" alt="GitHub">View Source Code</a></p>
		</footer>
	</body>
</html>
<?php
	}
	catch (PDOException $e) {
		exit("<p><b class=\"error\">Error: {$e->getMessage()}</b></p>");
	}
}
else {
	try {
	?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>WDV341 Event Form</title>
		<link rel="stylesheet" href="/homework/assets/css/style.css" />
		<link rel="icon" type="image/png" href="/images/favicon.png" />
	</head>
	<body>
		<header>
			<h1>WDV341 Event Form</h1>
			<h2>Tanner Babcock</h2>
		</header>
<?php
		if (!isset($_POST['event_id']) || !isset($_POST['event_name']) || !isset($_POST['event_presenter']) || !isset($_POST['event_date']) || !isset($_POST['event_time']) || !isset($_POST['event_description'])) {
			echo "<main style=\"text-align:center\"><p><b class=\"error\">One or more fields are empty.</b></p></main>";
		}
		else if ((strlen($_POST['event_date']) < 10) || (strlen($_POST['event_time']) < 8)) {
			echo "<main style=\"text-align:center\"><p><b class=\"error\">Event date and/or event time fields are malformed.</b></p></main>";
		}
		else {
			$id = intval($_POST['event_id']);
			$name = $_POST['event_name'];
			$presenter = $_POST['event_presenter'];
			$tdate = $_POST['event_date'];
			$ttime = $_POST['event_time'];
			$descript = $_POST['event_description'];

			$st = $db->prepare("INSERT INTO `wdv341_events` VALUES (:id, :name, :description, :presenter, :tdate, :ttime)");
			$st->bindParam(":id", $id);
			$st->bindParam(":name", $name);
			$st->bindParam(":description", $descript);
			$st->bindParam(":presenter", $presenter);
			$st->bindParam(":tdate", $tdate);
			$st->bindParam(":ttime", $ttime);

			$st->execute();

			echo "<main style=\"text-align:center\"><p><b class=\"success\">New event successfully posted</b></p></main>";
		}
		?>
		<main id="events-form">
			<form action="inputEvent" method="post" enctype="multipart/form-data">
				<h2>Editing Event "<?php echo $name; ?>"</h2>
				<div class="formFlex">
					<label for="event_id">Event ID:</label>
					<input type="number" name="event_id" value="<?php echo $_POST['event_id']; ?>" title="ID of the event. Should be auto-generated" alt="ID of the event. Should be auto-generated" />
				</div>
				<div class="formFlex">
					<label for="event_name">Event Name:</label>
					<input type="text" name="event_name" value="<?php echo $_POST['event_name']; ?>" title="Name of the event" alt="Name of the event" placeholder="The Big Big Event" />
				</div>
				<div class="formFlex">
					<label for="event_presenter">Event Presenter:</label>
					<input type="text" name="event_presenter" value="<?php echo $_POST['event_presenter']; ?>" title="Who is presenting this event?" alt="Who is presenting this event?" placeholder="Mr. Man" />
				</div>
				<div class="formFlex">
					<label for="event_date">Event Date (<i>in the format YYYY-MM-DD</i>):</label>
					<input type="text" name="event_date" value="<?php echo $_POST['event_date']; ?>" maxlength="10" title="When does this event take place?" alt="When does this event take place?" placeholder="YYYY-MM-DD" />
				</div>
				<div class="formFlex">
					<label for="event_time">Event Time (<i>in the format HH:MM:SS</i>):</label>
					<input type="text" name="event_time" value="<?php echo $_POST['event_time']; ?>" maxlength="8" size="9" title="What time does this event start?" alt="What time does this event start?" placeholder="HH:MM:SS" />
				</div>
				<center>
					<label for="event_description"><b>Event Description:</b></label>
					<textarea name="event_description" cols="40" rows="3" title="Enter the description for this event" alt="Enter the description for this event" placeholder="Wow we got some good stuff at this one!"><?php echo $_POST['event_description']; ?></textarea>
				</center>
				<div class="buttons">
					<input type="submit" value="Submit" name="submit" /> &bull;
					<input type="reset" value="Reset" />
				</div>
			</form>
		</main>
		<footer>
			<p><a href="eventForm.html" title="Previous assignment" alt="Previous assignment">Unit 11: Events Input Form</a> &bull; <a href="eventsForm" title="Next assignment" alt="Next assignment">Unit 12: SQL INSERT</a></p>
			<p><a href="/homework/index">&rarr; Return to WDV341 Homework &larr;</a> &bull; <a href="https://github.com/Babkock/homework/blob/master/wdv341/inputEvent.php" target="_blank" title="GitHub" alt="GitHub">View Source Code</a></p>
		</footer>
	</body>
</html>
			<?php
	}
	catch (PDOException $e) {
		exit("<p><b class=\"error\">Error: {$e->getMessage()}</b></p>");
	}
}

?>