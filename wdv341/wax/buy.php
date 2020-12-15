<?php
/*
	buy.php

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");
Methods::authorize();

try {
	if (!empty($_POST)) {
		if (!isset($_POST['choice'])) {
			$buy = new Page("header_user", "about");
			$buy->error("<p class=\"error\">Sorry, can't buy this album.</p>");
		}
		else if (strcmp($_POST['choice'], "Buy This Album") == 0) {
			if (!isset($_GET['id'])) {
				$buy = new Page("header_user", "about");
				$buy->error("<p class=\"error\">No 'id' argument given.</p>");
			}
			else {
				$buy = new Page("header_user", "about");

				$album = new Album(intval($_GET['id']));
				$album->read();
				$album->purchase($_SESSION['current_user']);
				$uid = Methods::getIdFromName($_SESSION['current_user']);
				$curr = Methods::currencySymbol($album->getCurrency());
				$p = number_format((float)$album->price, 2, ".", "");

				$sid = $album->getSellerId();
				$posted = date("F j, Y", strtotime($album->getPosted()));
				$sell = new User(intval($sid));
				$sell->read();

				$to = $sell->getEmail();
				$subject = $_SESSION['current_user'] . " purchased your album " . $album->getArtist() . " - " . $album->getTitle() . " on WaXchange!";
				$message = "<h1>Cha-ching! Pay day!</h1>";
				$message .= "<h3>Buyer: <a href=\"https://tannerbabcock.com/homework/wdv341/wax/user?id=" . $uid . "\" title=\"WaXchange\" alt=\"WaXchange\">" . $_SESSION['current_user'] . "</a></h3>";
				$message .= "<h3>Sale: " . $curr . $p . "</h3>";
				$message .= "<p>I bet you're happy right now! Congratulations on making a sale on WaXchange music marketplace. You posted this album for sale <b>" . $posted . "</b>.</p>";
				$message .= "<center><a href=\"https://tannerbabcock.com/homework/wdv341/wax/index\" title=\"Dashboard\" alt=\"Dashboard\">WaXchange Dashboard</a></center>";

				$header = "From:tanner@tannerbabcock.com \r\n";
				$header .= "Cc:" . $_POST['email'] . " \r\n";
				$header .= "MIME-Version: 1.0\r\n";
				$header .= "Content-type: text/html\r\n";

				if (mail($to, $subject, $message, $header) == false) {
					$buy->error("<h3>This album has been purchased, but there was a problem sending the seller an email.</h3>");
				}
				else {
					$buy->error("<h3>You have purchased " . $album->getArtist() . " - " . $album->getTitle() . " for $" . $album->price . "! Thank you for your business.</h3>\n<p class=\"success\">This release is now in your collection. <a href=\"index\">View your collection here.</a></p>");
				}
			}
		}
		exit();
	}
	else {
		$buy = new Page("header_user", "buy");
		$buy->setTitle("Buying {{ALBUM_TITLE}}");
		$buy->setDescription("This is the purchase confirmation page for the album {{ALBUM_ARTIST}} - {{ALBUM_TITLE}}.");
		if (!isset($_GET['id'])) {
			$buy->error("<p class=\"error\">No 'id' argument given.</p>");
			exit();
		}
		else {
			$uid = Methods::getIdFromName($_SESSION['current_user']);

			$st = $db->prepare("SELECT * FROM `albums` WHERE `id`=:id");
			$st->bindParam(":id", intval($_GET['id']));
			$st->execute();

			$row = $st->fetch(PDO::FETCH_ASSOC);
			$buy->ogImage("https://tannerbabcock.com/homework/wdv341/wax/" . $row['image']);

			if (strlen($row['buyer']) > 1) {
				$buy->error("<h2>Sorry, this album has been sold.</h2>");
				exit();
			}

			$tl = json_decode($row['tracklist']);
			$tlout = "<table class=\"track-list\"><tbody>";
			$x = 1;

			foreach ($tl as $k => $v) {
				$tlout .= <<<EOF
				<tr>
					<td>{$x}.</td>
					<td>{$v->title}</td>
					<td>{$v->length}</td>
EOF;
				$x++;
			}
			$tlout .= "</tbody></table>";
			$price = number_format((float)$row['price'], 2, ".", "");

			$buy->hreplacea([
				"USERID" => $uid,
				"ALBUM_TITLE" => $row['title'],
				"ALBUM_ARTIST" => $row['artist']
			]);
			$buy->replacea([
				"USERNAME" => $_SESSION['current_user'],
				"ALBUM_ID" => $row['id'],
				"ALBUM_HREF" => "browse?b=" . urlencode(ucwords($row['title'])),
				"ARTIST_HREF" => "browse?a=" . urlencode(ucwords($row['artist'])),
				"ALBUM_TITLE" => $row['title'],
				"ALBUM_ARTIST" => $row['artist'],
				"ALBUM_MEDIA" => $row['media'],
				"ALBUM_PRICE" => $price,
				"ALBUM_IMAGE" => $row['image'],
				"ALBUM_DISCS" => $row['discs'],
				"ALBUM_POSTED" => date("F j, Y", strtotime($row['posted'])),
				"ALBUM_LABEL" => $row['label'],
				"ALBUM_COUNTRY" => Methods::countryExpand($row['country']),
				"ALBUM_SELLER" => $row['seller'],
				"SELLER_HREF" => "user?id=" . $row['sellerid'],
				"TRACKLIST" => $tlout,
				"ALBUM_YEAR" => $row['year'],
				"ALBUM_COND" => Methods::conditionExpand($row['cond']),
				"CURRENCY_SYMBOL" => Methods::currencySymbol($row['currency'])
			]);
		}
		$buy->output();
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
