<!DOCTYPE html>
<?php
/*
	Unit 11: Form Validation
	November 10, 2020
	Tanner Babcock
*/

$nameErr = "";
$emailErr = "";
$phoneErr = "";
$regisErr = "";

/*
$fullName = "";
$email = "";
$phoneNumber = "";
$registration = "";
$badgeHolder = "";
$providedMeals = "";
$specialRequest = "";
*/

$validForm = false;

/*
	Form Validation Plan:

	- Validate Name (Cannot be blank, no special characters, two words)
	- Validate Email (Use Regular Expressions, must have a '@' and a '.')
	- Validate Phone Number (Must be 10 digits)
*/

function validateName($name) {
	global $validForm, $nameErr;

	if (strpos($name, " ") === false) {
		$nameErr = "Name does not contain a space.";
		$validForm = false;
		return 1;
	}
	if ((strlen($name) < 5) || (strlen($name) > 40)) {
		$nameErr = "Name is too long or too short.";
		$validForm = false;
		return 1;
	}
	return 0;
}

function validatePhoneNumber($phone) {
	global $validForm, $phoneErr;

	return 0;
}

function validateEmail($email) {

	return 0;
}
?>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>WDV341 Intro PHP - Form Validation Example</title>
	<link rel="stylesheet" href="/homework/assets/css/style.css" />
	<link rel="icon" type="image/png" href="/images/favicon.png" />
</head>
<body>
	<h1>WDV341 Intro PHP</h1>
	<h2>Form Validation Assignment</h2>
	<div id="orderArea">
		<form id="form1" name="form1" method="post" action="formValidationAssignment" enctype="multipart/form-data">
			<h3>Customer Registration Form</h3>
			<table width="587" border="0">
			<tr>
				<td width="117">Name:</td>
				<td width="246"><input type="text" name="fullName" size="40" value=""/></td>
				<td width="210" class="error"></td>
			</tr>
			<tr>
				<td>Social Security</td>
				<td><input type="text" name="inEmail" id="inEmail" size="40" value="" /></td>
				<td class="error"></td>
			</tr>
			<tr>
				<td>Choose a Response</td>
				<td><p>
					<label><input type="radio" name="RadioGroup1" id="RadioGroup1_0">Phone</label>
					<br />
					<label><input type="radio" name="RadioGroup1" id="RadioGroup1_1">Email</label>
					<br />
					<label><input type="radio" name="RadioGroup1" id="RadioGroup1_2">US Mail</label>
					<br />
				</p></td>
				<td class="error"></td>
			</tr>
			</table>
			<p>
				<input type="submit" name="submit" id="button" value="Register" />
				<input type="reset" name="button2" id="button2" value="Clear Form" />
			</p>
		</form>
	</div>
	<footer>
		<p><a href="/homework/index">&rarr; Return to WDV341 Homework &larr;</a> &bull; <a href="https://github.com/Babkock/homework/blob/master/wdv341/formValidationAssignment.php" target="_blank" title="GitHub" alt="GitHub">View Source Code</a></p>
	</footer>
</body>
</html>
