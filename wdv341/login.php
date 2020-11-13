<!DOCTYPE html>
<?php
/*
	Unit 13: Login and Protected Pages
	November 10, 2020
	Tanner Babcock
*/
session_start();
require_once("dbConnect.php");

function showAdminArea($user = "") {
	?>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Welcome, <?php echo $user; ?></title>
	<link rel="stylesheet" href="/homework/assets/css/style.css" />
	<link rel="icon" href="/images/favicon.png" />
</head>
<body>
	<header>
		<nav>
			<ul>
				<li><a href="login">Admin Home</a></li>
				<li><a href="eventsForm">New Event</a></li>
				<li><a href="eventsList">Show All Events</a></li>
				<li><a href="logout">Logout</a></li>
			</ul>
		</nav>
	</header>
	<main id="admin">

	</main>
	<footer>
		<p><a href="/homework/index?c=wdv341">&rarr; Return to WDV341 Homework &larr;</a> &bull; <a href="https://github.com/Babkock/homework/blob/master/wdv341/login.php" target="_blank" title="GitHub" alt="GitHub">View Source Code</a></p>
	</footer>
</body>
</html>
	<?php
}

function showLoginForm($warning = false, $user = "") {
	?>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Login Page</title>
	<meta name="description" content="Login page for the PHP Events Admin." />
	<link rel="stylesheet" href="/homework/assets/css/style.css" />
	<link rel="icon" href="/images/favicon.png" />
</head>
<body>
	<header>
		<nav class="guest">
			<ul>
				<li><a href="login">Login</a></li>
				<li><a href="selectEvents">Show Events</a></li>
			</ul>
		</nav>
	</header>
	<main id="login-form">
		<?php
		if (($warning) && (strlen($user) > 2)) {
			?>
		<div class="error">
			<p class="error">Username or password invalid. Please try again.</p>
		</div>
			<?php
		}
		?>
		<form action="login" class="login" enctype="multipart/form-data">
			<table><tbody>

			</tbody></table>
		</form>
	</main>
	<footer>
		<p><a href="/homework/index?c=wdv341">&rarr; Return to WDV341 &larr;</a> &bull; <a href="https://github.com/Babkock/homework/blob/master/wdv341/login.php" target="_blank" title="GitHub" alt="GitHub">View Source Code</a></p>
	</footer>
</body>
</html>
	<?php
}

try {
	if (!empty($_POST)) {
		$st = $db->prepare("SELECT `event_user_id`, `event_user_name`, `event_user_password` FROM `event_user`");
		$st->execute();

		$_SESSION['valid_user'] = false;
		while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
			if ((strcmp($row['event_user_name'], $_POST['username']) == 0) &&
				(strcmp($row['event_user_password'], $_POST['password']) == 0)) {
				$_SESSION['valid_user'] = true;
				$_SESSION['current_user'] = $_POST['username'];
				break;
			}
		}

		if ($_SESSION['valid_user'] == true) {
			header('Location: /homework/wdv341/login');
			exit();
		}
		else {
			/* show login form with error */
			showLoginForm(true, $_POST['username']);
		}
	}
	else {
		if ($_SESSION['valid_user'] == true) {
			showAdminArea($_SESSION['current_user']);
		}
		else {
			/* show login form */
			showLoginForm();
		}
	}

}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
