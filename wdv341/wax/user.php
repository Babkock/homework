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
				if (strcmp($_GET['mode'], "inventory") == 0) {
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
				$out .= <<<EOF
				{
					"id": {$row['id']},
					"artist": "{$row['artist']}",
					"title": "{$row['title']}",
					"media": "{$row['media']}",
					"discs": {$row['discs']},
					"price": {$row['price']},
					"seller": "{$row['seller']}",
					"buyer": "{$row['buyer']}",
					"image": "{$row['image']}",
					"label": "{$row['label']}",
					"posted": "{$row['posted']}",
					"country": "{$row['country']}",
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
			$userpage->setTitle("WaXchange &bull; User {{USERNAME}}");
			$userpage->setDescription("This is the account page for user {{USERNAME}} on WaXchange.");

			$st = $db->prepare("SELECT `id`, `username`, `email`, `country` FROM `users` WHERE `id`=:id LIMIT 1");
			$st->bindParam(":id", intval($_GET['id']));
			$st->execute();

			$row = $st->fetch(PDO::FETCH_ASSOC);
			if (!$row) {
				$userpage->error("The specified user does not exist.");
				exit();
			}
			else {
				$userpage->replacea([
					"USERID" => $row['id'],
					"USERNAME" => $row['username'],
					"USEREMAIL" => $row['email'],
					"USERCOUNTRY" => Methods::countryExpand($row['country']),
					"EDITBUTTON" => ((strcmp($_SESSION['current_user'], $row['username']) == 0) ? "<button class=\"buy\" @click=\"EditAlbum(al.id)\">Edit Release</button>" : "<button class=\"buy\" @click=\"BuyAlbum(al.id)\">Buy This Album</button>")
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
		/* maybe show user directory here, if no $id given? */
			$st = $db->prepare("SELECT `username`, `id`, `email` FROM `users` ORDER BY `id` ASC");
			// $st = $db->prepare("SELECT `username`, `id`, `email`, `showemail`, `purchases`, `sales` FROM `users` ORDER BY `id` ASC");
			$st->execute();

			$out = "<main id=\"users\">\n\t<table class=\"users-table\">\n\t"; 
			$out .= "<thead><tr><td><b>ID</b></td><td><b>Username</b></td><td><b>Email Address</b></td></tr></thead>\n\t<tbody>\n";
			while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
				$out .= <<<EOF
		<tr>
			<td>{$row['id']}</td>
			<td><a href="user?id={$row['id']}">{$row['username']}</a></td>
			<td><a href="mailto:{$row['email']}">{$row['email']}</a></td>
		</tr>
EOF;
			}
			$userpage->setContent($out);
		}
		$userpage->output();
	}
}
catch (PDOException $e) {
	exit("{ \"error\": \"{$e->getMessage()}\" }");
}
