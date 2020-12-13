<?php
/*
	user.php

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock
*/
require_once("lib/waxchange.php");

try {
	if (!empty($_POST)) {
		/* account album listing AJAX */
		if (!isset($_POST['id'])) {
			if (!isset($_POST['name'])) {
				header('Content-Type: application/json');
				exit("{ \"error\": \"No user ID or name to fetch\"}");
			}
			else { // when name is given, but ID isn't, just echo the ID for the given username
				$st2 = $db->prepare("SELECT `id` FROM `users` WHERE `username`=:name LIMIT 1");
				$st2->bindParam(":name", $_POST['name']);
				$st2->execute();

				$r = $st2->fetch(PDO::FETCH_ASSOC);
				header('Content-Type: application/json');
				if ($r) {
					exit("{ \"userid\": " . $r['id'] . " }");
				}
				else {
					exit("{ \"error\": \"No user by that name exists\"}");
				}
			}
		}
		else {
			$st1 = $db->prepare("SELECT `username` FROM `users` WHERE `id`=:id LIMIT 1");
			$st1->bindParam(":id", intval($_POST['id']));
			$st1->execute();

			$r = $st1->fetch(PDO::FETCH_ASSOC);
			$seller = $r['username'];
			$buyer = $r['username'];
			if (isset($_GET['mode'])) {
				if (strcmp($_GET['mode'], "sold") == 0) {
					$st = $db->prepare("SELECT * FROM `albums` WHERE `seller`=:seller AND `purchased` IS NOT NULL ORDER BY `purchased` DESC");
					$st->bindParam(":seller", $seller);
				}
				else if (strcmp($_GET['mode'], "inventory") == 0) {
					$st = $db->prepare("SELECT * FROM `albums` WHERE `seller`=:seller ORDER BY `posted` DESC");
					$st->bindParam(":seller", $seller);
				}
				else if (strcmp($_GET['mode'], "purchased") == 0) {
					$st = $db->prepare("SELECT * FROM `albums` WHERE `buyer`=:buyer ORDER BY `posted` DESC");
					$st->bindParam(":buyer", $buyer);
				}
			}
			else {
				/* assume inventory mode if no parameter */
				$st = $db->prepare("SELECT * FROM `albums` WHERE `seller`=:seller ORDER BY `posted` DESC");
				$st->bindParam(":seller", $seller);
			}
			$st->execute();
			header('Content-Type: application/json');

			$out = "[";
			$x = 0;
			while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
				if ($x > 0)
					$out .= ",\n";
				$pur = ((strlen($row['purchased']) > 1) ? $row['purchased'] : "n");
				$price = number_format((float)$row['price'], 2, ".", "");
				$out .= <<<EOF
				{
					"id": {$row['id']},
					"artist": "{$row['artist']}",
					"title": "{$row['title']}",
					"media": "{$row['media']}",
					"discs": {$row['discs']},
					"price": "{$price}",
					"seller": "{$row['seller']}",
					"buyer": "{$row['buyer']}",
					"image": "{$row['image']}",
					"label": "{$row['label']}",
					"posted": "{$row['posted']}",
					"country": "{$row['country']}",
					"year": "{$row['year']}",
					"cond": "{$row['cond']}",
					"currency": "{$row['currency']}",
					"purchased": "{$pur}",
					"sellerid": {$row['sellerid']},
					"buyerid": {$row['buyerid']},
					"tracklist": {$row['tracklist']}
				}
EOF;
				$x++;
			}
			$out .= "]";
			exit($out);
		}
	}
	else {
		if (isset($_SESSION['current_user'])) {
			$userpage = new Page("header_user", "account");
			$uid = Methods::getIdFromName($_SESSION['current_user']);
			$userpage->hreplace("USERID", $uid);
		}
		else
			$userpage = new Page("header_guest", "account");

		if (isset($_GET['id'])) {
			$userpage->setTitle("{{USERNAME}} &bull; WaXchange");
			$userpage->setDescription("This is the account page for user {{USERNAME}} on WaXchange.");

			$st = $db->prepare("SELECT * FROM `users` WHERE `id`=:id LIMIT 1");
			$st->bindParam(":id", intval($_GET['id']));
			$st->execute();

			$row = $st->fetch(PDO::FETCH_ASSOC);
			if (!$row) {
				$userpage->error("<p class=\"error\">The specified user does not exist.</p>");
				exit();
			}
			else {
				$userpage->ogImage("https://tannerbabcock.com/homework/wdv341/wax/" . $row['image']);
				$userpage->hreplace("USERNAME", $row['username']);

				if (isset($_SESSION['current_user'])) {
					if (strcmp($_SESSION['current_user'], $row['username']) == 0)
						$button = "<button class=\"buy edit\" @click=\"EditAlbum(al.id)\">Edit Release</button>&nbsp;&nbsp;&nbsp;&nbsp;\n\t\t<button class=\"buy delete\" @click=\"DeleteAlbum(al.id)\">Delete Release</button>";
					else
						$button = "<button class=\"buy\" @click=\"BuyAlbum(al.id)\">Buy This Album</button>";
				}
				else {
					$button = "<button class=\"buy\" @click=\"Register()\">Buy This Album</button>";
				}

				$semail = "";

				if (intval($row['showemail']) == 1)
					$semail = "<b>Hidden</b>";
				else if (intval($row['showemail']) == 2) {
					$email = str_replace(".", " dot ", str_replace("@", " at ", $row['email']));
					$semail = "<a href=\"mailto:" . $row['email'] . "\">" . $email . "</a>";
				}
				else if (intval($row['showemail']) == 3) {
					$semail = "<a href=\"mailto:" . $row['email'] . "\">" . $row['email'] . "</a>";
				}

				$userpage->replacea([
					"USERID" => $row['id'],
					"USERNAME" => $row['username'],
					"USEREMAIL" => $semail,
					"USERIMG" => $row['image'] ?? "img/user/default.jpg",
					"USERCOUNTRY" => Methods::countryExpand($row['country']),
					"BIOGRAPHY" => $row['biography'],
					"REGISTERED" => date("F j, Y", strtotime($row['registered'])),
					"SALES" => $row['sales'],
					"EDITBUTTON" => $button
				]);

				if (isset($_SESSION['current_user'])) {
					$userpage->setContent(Methods::snip("{{IF_NOT_LOGGED_IN}}", "{{ENDNIF}}", $userpage->getContent()));
					$userpage->setContent(str_replace("{{IF_LOGGED_IN}}", "", $userpage->getContent()));
					$userpage->setContent(str_replace("{{ENDIF}}", "", $userpage->getContent()));
				}
				else {
					$userpage->setContent(Methods::snip("{{IF_LOGGED_IN}}", "{{ENDIF}}", $userpage->getContent()));
					$userpage->setContent(str_replace("{{IF_NOT_LOGGED_IN}}", "", $userpage->getContent()));
					$userpage->setContent(str_replace("{{ENDNIF}}", "", $userpage->getContent()));
				}
			}
		}
		else {
			$userpage->setTitle("WaXchange &bull; Users");
			$userpage->setDescription("This is the complete list of users on WaXchange music marketplace.");
			$userpage->ogImage("https://tannerbabcock.com/homework/wdv341/wax/img/bigbg.jpg");
			$st = $db->prepare("SELECT `username`, `id`, `email`, `showemail`, `registered` FROM `users` ORDER BY `id` ASC");
			$st->execute();

			$out = "<main id=\"users\">\n\t<h2>Users on WaXchange</h2>\n\t<table class=\"users-table\">\n\t"; 
			$out .= "<thead><tr><td><b>ID</b></td><td><b>Username</b></td><td><b>Email Address</b></td><td><b>Date Registered</b></td></tr></thead>\n\t<tbody>\n";

			while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
				$reg = date("F j, Y", strtotime($row['registered']));
				if ($row['showemail'] == 1)
					$semail = "<b>Hidden</b>";
				else if ($row['showemail'] == 2) {
					$email = str_replace(".", " dot ", str_replace("@", " at ", $row['email']));
					$semail = "<a href=\"mailto:" . $row['email'] . "\">" . $email . "</a>";
				}
				else if ($row['showemail'] == 3)
					$semail = "<a href=\"mailto:" . $row['email'] . "\">" . $row['email'] . "</a>";
				else
					$semail = "<b>Hidden</b>";

				$out .= <<<EOF
		<tr>
			<td>{$row['id']}</td>
			<td><a href="user?id={$row['id']}">{$row['username']}</a></td>
			<td>{$semail}</td>
			<td>{$reg}</td>
		</tr>
EOF;
			}
			$out .= "</tbody></table>\n</main>";
			$userpage->setContent($out);
		}
		$userpage->output();
	}
}
catch (PDOException $e) {
	exit("{ \"error\": \"{$e->getMessage()}\" }");
}
