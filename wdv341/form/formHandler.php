<?php
/*
	Unit 10: PHP Form Processing
	October 20, 2020
	Tanner Babcock
*/
//Model-Controller Area.  The PHP processing code goes in this area. 

	//Method 1.  This uses a loop to read each set of name-value pairs stored in the $_POST array
	$tableBody = "";		//use a variable to store the body of the table being built by the script
	
	foreach ($_POST as $key => $value)		//This will loop through each name-value in the $_POST array
	{
		$tableBody .= "<tr>";				//formats beginning of the row
		$tableBody .= "<td>$key</td>";		//dsiplay the name of the name-value pair from the form
		$tableBody .= "<td>\"$value\"</td>";	//dispaly the value of the name-value pair from the form
		$tableBody .= "</tr>";				//End this row
	} 
	
	
	//Method 2.  This method pulls the individual name-value pairs from the $_POST using the name
	//as the key in an associative array.  
	
	$inFirstName = $_POST["firstName"];		//Get the value entered in the first name field
	$inLastName = $_POST["lastName"];		//Get the value entered in the last name field
	$inSchool = $_POST["school"];			//Get the value entered in the school field
	if (!isset($_POST["attendance"])) {
		echo "<p><b>Error:</b> No attendance selected</p>";
		$attendanceType = "";
	}
	else {
		$attendanceType = $_POST["attendance"];
	}
	if (!isset($_POST["services"])) {
		echo "<p><b>Error:</b> No services selected</p>";
		$services = "";
	}
	else {
		$services = $_POST["services"];
	}
	if (strcmp($_POST["major"], "Choose a Major") == 0) {
		echo "<p><b>Error:</b> No major selected</p>";
		$major = "None";
	}
	else {
		$major = $_POST["major"];
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>WDV 341 Intro PHP - Code Example</title>
	<link rel="stylesheet" href="/homework/assets/css/style.css" />
	<link rel="icon" type="image/png" href="/images/favicon.png" />
</head>
<body>
	<header>
		<h1>WDV341 Intro PHP</h1>
		<h2>Form Handler Result Page - Code Example</h2>
	</header>
	<p>This page displays the results of the Server side processing. </p>
	<p>The PHP page has been formatted to use the Model-View-Controller (MVC) concepts. </p>
	<h3>Display the values from the form using Method 1. Uses a loop to process through the $_POST array</h3>
	<p>
		<table class="ftable"><tbody>
			<tr>
				<td>Field Name</td>
				<td>Value of Field</td>
			</tr>
		<?php echo $tableBody;  ?>
		</tbody></table>
	</p>
	<h3>Display the values from the form using Method 2. Displays the individual values.</h3>
	<div class="box big">
		<p>School: <b><?php echo $inSchool; ?></b></p>
		<p>First Name: <b><?php echo $inFirstName; ?></b></p>
		<p>Last Name: <b><?php echo $inLastName; ?></b></p>
		<p>Attending: <b><?php echo $attendanceType; ?></b></p>
		<p>Services: <b><?php echo $services; ?></b></p>
		<p>Major: <b><?php echo $major; ?></b></p>
	</div>
	<footer>
		<p><a href="../deliverEventObject" alt="Previous assignment" title="Previous assignment">Unit 9: Formatting JSON Output/AJAX</a> &bull; <a href="../eventForm.html" alt="Next assignment" title="Next assignment">Unit 11: Events Input Form</a></p>
		<p><a href="/homework/index">&rarr; Return to WDV341 Homework &larr;</a> &bull; <a href="https://github.com/Babkock/homework/blob/master/wdv341/form/formHandler.php" target="_blank">View Source Code</a></p>
	</footer>
</body>
</html>
