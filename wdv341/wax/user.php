<?php
/*
	user.php

	WaXchange PHP Project
	November - December 2020
	Copyright (c) 2020 Tanner Babcock
*/
require_once("lib/waxchange.php");

try {
	if (!empty($_POST)) {
		/* account album listing AJAX */
		if (!isset($_POST['id'])) {
			exit("{ \"error\": \"No user ID to fetch\"}");
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
		$userpage = new Page("account");
		if (isset($_GET['id'])) {
			$userpage->setTitle("WaXchange &bull; User {{USERNAME}}");
			$userpage->setDescription("This is the account page for user {{USERNAME}} on WaXchange.");

			$st = $db->prepare("SELECT `id`, `username`, `email` FROM `users` WHERE `id`=:id LIMIT 1");
			$st->bindParam(":id", intval($_GET['id']));

			$st->execute();

			$row = $st->fetch(PDO::FETCH_ASSOC);
			if (!$row) {
				$userpage->error("The specified user does not exist.");
			}
			else {
				$userpage->replacea([
					"USERID" => $row['id'],
					"USERNAME" => $row['username'],
					"USEREMAIL" => $row['email']
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
			$userpage->error("The specified user does not exist.");
		}
		$userpage->output();
	}
}
catch (PDOException $e) {
	exit("{ \"error\": \"{$e->getMessage()}\" }");
}
