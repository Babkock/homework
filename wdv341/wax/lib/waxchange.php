<?php
/*
	waxchange.php

	WaXchange PHP Project
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
session_start();
require_once("../dbConnect.php");

$passkey = file_get_contents(__DIR__ . "/./passkey.txt");


/*
	Albums Table
	_________________________________________________________________________
	| id          | INT(11)      | The unique ID of the album for sale.     |
	|-------------|--------------|------------------------------------------|
	| artist      | VARCHAR(90)  | The musical artist who made this album.  |
	|-------------|--------------|------------------------------------------|
	| title       | VARCHAR(90)  | The title of the album.                  |
	|-------------|--------------|------------------------------------------|
	| media       | VARCHAR(10)  | Media (vinyl, CD, cassette).             |
	|-------------|--------------|------------------------------------------|
	| discs       | INT(11)      | Number of discs (2xCD, 3xLP, etc).       |
	|-------------|--------------|------------------------------------------|
	| price       | FLOAT        | The price of the album, set by the user. |
	|-------------|--------------|------------------------------------------|
	| seller      | VARCHAR(80)  | The user who is selling this album.      |
	|-------------|--------------|------------------------------------------|
	| buyer       | VARCHAR(80)  | The user who bought the album, or NULL.  |
	|-------------|--------------|------------------------------------------|
	| image       | VARCHAR(50)  | The image file for the album cover.      |
	|-------------|--------------|------------------------------------------|
	| label       | VARCHAR(90)  | Record label that released the album.    |
	|-------------|--------------|------------------------------------------|
	| posted      | DATE         | The date the album was posted for sale.  |
	|-------------|--------------|------------------------------------------|
	| country     | VARCHAR(2)   | Country code for where the album is from.|
	|-------------|--------------|------------------------------------------|
	| tracklist   | TEXT         | JSON data for the track listing.         |
	|_____________|______________|__________________________________________|
*/

class Album {
	private $id;
	private $artist;
	private $title;
	private $media;
	private $discs;
	private $tracklist;
	private $buyer;
	private $seller;
	private $image;
	private $label;
	private $posted;
	public $price;
	public $country;

	public function __construct($id = 0) {
		if (strcmp(gettype($id), "integer") != 0) {
			exit("<p class=\"error\">First argument of new Album() must be integer</p>");
		}
		$this->id = $id;
	}

	public function getId() { return $this->id; }
	public function getArtist() { return $this->artist; }
	public function setArtist($a) { $this->artist = $a; }
	public function getTitle() { return $this->title; }
	public function setTitle($b) { $this->title = $b; }
	public function getMedia() { return $this->media; }
	public function setMedia($m) { $this->media = $m; }
	public function getDiscs() { return $this->discs; }
	public function setDiscs($d) { $this->discs = $d; }
	public function getTracklist() { return json_decode($this->tracklist); }
	public function setTracklist($t) { $this->tracklist = json_encode($t); }
	public function getBuyer() { return $this->buyer; }
	public function setBuyer($b) { $this->buyer = $b; }
	public function getSeller() { return $this->seller; }
	public function setSeller($s) { $this->seller = $s; }
	public function getImage() { return $this->image; }
	public function setImage($i) { $this->image = $i; }
	public function getLabel() { return $this->label; }
	public function setLabel($l) { $this->label = $l; }
	public function getPosted() { return $this->posted; }
	public function setPosted($p) { $this->posted = $p; }

	public function seta($arr) {
		foreach ($arr as $k => $v) {
			if (strcmp($k, "artist") == 0) { $this->artist = $v; }
			if (strcmp($k, "title") == 0) { $this->title = $v; }
			if (strcmp($k, "media") == 0) { $this->media = $v; }
			if (strcmp($k, "discs") == 0) { $this->discs = $v; }
			if (strcmp($k, "price") == 0) { $this->price = $v; }
			if (strcmp($k, "country") == 0) { $this->country = $v; }
			if (strcmp($k, "posted") == 0) { $this->posted = $v; }
			if (strcmp($k, "seller") == 0) { $this->seller = $v; }
			if (strcmp($k, "buyer") == 0) { $this->buyer = $v; }
			if (strcmp($k, "tracklist") == 0) {
				$this->tracklist = [];
				$tl = json_decode($v);

				foreach ($tl as $track) {
					array_push($this->tracklist, [$track->title, $track->length]);
				}
			}
		}
	}

	public function geta() {
		$arr = [];
		$arr['id'] = $this->id;
		$arr['artist'] = $this->artist;
		$arr['title'] = $this->title;
		$arr['media'] = $this->media;
		$arr['discs'] = $this->discs;
		$arr['price'] = $this->price;
		$arr['country'] = $this->country;
		$arr['posted'] = $this->posted;
		$arr['seller'] = $this->seller;
		$arr['buyer'] = $this->buyer;
		$arr['tracklist'] = $this->tracklist;
		return $arr;
	}

	public function consume($albumJson) {
		$b = json_decode($albumJson);

		$this->id = $b->id;
		$this->artist = $b->artist;
		$this->title = $b->title;
		$this->media = $b->media;
		$this->discs = $b->discs;
		$this->price = $b->price;
		$this->country = $b->country;
		$this->posted = $b->posted;
		$this->seller = $b->seller;
		$this->buyer = $b->buyer;
		$this->tracklist = [];

		foreach ($b->tracklist as $track) {
			array_push($this->tracklist, [$track->title, $track->length]);
		}
	}

	public function read() {
		global $db;

		$st = $db->prepare("SELECT * FROM `albums` WHERE `id`=:id LIMIT 1");
		$st->bindParam(":id", $this->id);

		$st->execute();
		$row = $st->fetch(PDO::FETCH_ASSOC);
		$this->seta($row);
	}

	public function write() {
		global $db;

		$st = $db->prepare("INSERT INTO `albums` VALUES (id, :artist, :title, :media, :discs, :price, :seller, :buyer, :image, :label, NOW(), :country, :tracklist)");
		$st->bindParam(":artist", $this->artist);
		$st->bindParam(":title", $this->title);
		$st->bindParam(":media", $this->media);
		$st->bindParam(":discs", $this->discs);
		$st->bindParam(":price", $this->price);
		$st->bindParam(":seller", $this->seller);
		$st->bindParam(":buyer", $this->buyer);
		$st->bindParam(":image", $this->image);
		$st->bindParam(":label", $this->label);
		$st->bindParam(":country", $this->country);

		$tlJson = "[";
		$t = 0;
		foreach ($this->tracklist as $track) {
			if ($t > 0) {
				$tlJson .= ",";
			}
			$tlJson .= "{";
			$tlJson .= "\"title\": \"" . $track[0] . "\",";
			$tlJson .= "\"length\": \"" . $track[1] . "\"";
			$tlJson .= "}";
			$t++;
		}
		$tlJson .= "]";
		$this->posted = date("Y-m-d", mktime());
		$st->bindParam(":tracklist", $tlJson);
		$st->execute();
	}

	public function update() {
		global $db;

		$st = $db->prepare("UPDATE `albums` SET `artist`=:artist, `title`=:title, `media`=:media, `discs`=:discs, `price`=:price, `seller`=:seller, `buyer`=:buyer, `image`=:image, `label`=:label, `posted`=NOW(), `country`=:country, `tracklist`=:tracklist WHERE `id`=:id LIMIT 1");
		$st->bindParam(":id", $this->id);
		$st->bindParam(":artist", $this->artist);
		$st->bindParam(":title", $this->title);
		$st->bindParam(":media", $this->media);
		$st->bindParam(":discs", $this->discs);
		$st->bindParam(":price", $this->price);
		$st->bindParam(":seller", $this->seller);
		$st->bindParam(":buyer", $this->buyer);
		$st->bindParam(":image", $this->image);
		$st->bindParam(":label", $this->label);
		$st->bindParam(":country", $this->country);

		$tlJson = "[";
		$t = 0;
		foreach ($this->tracklist as $track) {
			if ($t > 0) {
				$tlJson .= ",";
			}
			$tlJson .= "{";
			$tlJson .= "\"title\": \"" . $track[0] . "\",";
			$tlJson .= "\"length\": \"" . $track[1] . "\"";
			$tlJson .= "}";
			$t++;
		}
		$tlJson .= "]";
		$this->posted = date("Y-m-d", mktime());
		$st->bindParam(":tracklist", $tlJson);
		$st->execute();
	}
}

/*
	Users Table
	_________________________________________________________________________
	| id          | INT(11)      | The unique ID of the user.               |
	|-------------|--------------|------------------------------------------|
	| username    | VARCHAR(80)  | The user's name.                         |
	|-------------|--------------|------------------------------------------|
	| password    | VARCHAR(64)  | SHA256 Hash of the user's password.      |
	|-------------|--------------|------------------------------------------|
	| email       | VARCHAR(80)  | The user's email address.                |
	|-------------|--------------|------------------------------------------|
	| country     | VARCHAR(2)   | The country the user is from.            |
	|_____________|______________|__________________________________________|
*/

class User {
	private $id;
	private $username;
	private $password;
	private $email;
	private $country;

	public function __construct($id = 0) {
		$this->id = $id;
	}

	public function getId() { return $this->id; }
	public function getUsername() { return $this->username; }
	public function setUsername($u) { $this->username = $u; }
	public function getPassword() { return $this->password; }
	public function setPassword($p) { $this->password = $p; }
	public function getEmail() { return $this->email; }
	public function setEmail($e) { $this->email = $e; }
	public function getCountry() { return $this->country; }
	public function setCountry($c) { $this->country = $c; }

	public function seta($arr) {
		foreach ($arr as $k => $v) {
			if (strcmp($k, "username") == 0) { $this->username = $v; }
			if (strcmp($k, "password") == 0) { $this->password = $v; }
			if (strcmp($k, "email") == 0) { $this->email = $v; }
			if (strcmp($k, "country") == 0) { $this->country = $v; }
		}
	}

	public function geta() {
		$arr = [];
		$arr['id'] = $this->id;
		$arr['username'] = $this->username;
		$arr['password'] = $this->password;
		$arr['email'] = $this->email;
		$arr['country'] = $this->country;
		return $arr;
	}

	public function read() {
		global $db;

		$st = $db->prepare("SELECT * FROM `users` WHERE `id`=:id LIMIT 1");
		$st->bindParam(":id", $this->id);
		$st->execute();

		$row = $st->fetch(PDO::FETCH_ASSOC);
		$this->seta($row);
	}

	public function write() {
		global $db;

		$st = $db->prepare("INSERT INTO `users` VALUES (id, :username, :password, :email, :country)");
		$st->bindParam(":username", $this->username);
		$st->bindParam(":password", $this->password);
		$st->bindParam(":email", $this->email);
		$st->bindParam(":country", $this->country);
		$st->execute();
	}

	public function update() {
		global $db;

		$st = $db->prepare("UPDATE `users` SET `username`=:username, `password`=:password, `email`=:email, `country`=:country WHERE `id`=:id LIMIT 1")
		$st->bindParam(":id", $this->id);
		$st->bindParam(":username", $this->username);
		$st->bindParam(":password", $this->password);
		$st->bindParam(":email", $this->email);
		$st->bindParam(":country", $this->country);
		$st->execute();
	}
}

class Page {
	private $content;
	private $title;

	public function __construct($file = "") {
		if (!isset($file)) {
			exit("<p class=\"error\">No file for loading</p>");
		}
		$this->content = file_get_contents(__DIR__ . "/../views/" . $file . ".html");
	}

	public function getContent() { return $this->content; }
	public function setContent($c) { $this->content = $c; }
	public function getTitle() { return $this->title; }
	public function setTitle($t) {
		$this->title = $t;
		$this->replace("TITLE", $t);
	}
	public function setDescription($d) {
		$this->replace("DESCRIPTION", $d);
	}

	public function replace($plchold, $val = "") {
		$this->content = str_replace("{{" . $plchold . "}}", $val, $this->content);
	}

	public function replacea($arr) {
		foreach ($arr as $k => $v) {
			$this->content = str_replace("{{" . $k . "}}", $v, $this->content);
		}
	}

	public function error($message) {
		$this->content = <<<EOF
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>WaXchange &bull; Error</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="/homework/assets/css/waxchange.css" />
		<link rel="icon" href="/images/favicon.png" />
	</head>
	<body>
		<div class="container">
			<header>
				<h1><a href="index">WaXchange</a></h1>
			</header>
			<main id="error">
				<p class="error">{$message}</p>
			</main>
			<footer>
				<p><a href="about">About WaXchange</a> &bull; <a href="contact">Contact</a></p>
				<p><a href="/homework/index?c=wdv341">&rarr; Return to WDV341 Homework &larr;</a></p>
				<p>Copyright &copy; 2020 Tanner Babcock.
			</footer>
		</div>
	</body>
</html>
EOF;
	}

	public function script($s) {
		$this->content = str_replace("\t</body>\n</html>", "\t\t<script>" . file_get_contents(__DIR__ . "/../../../assets/js/" . $s) . "</script>\n\t</body>\n</html>", $this->content);
	}

	public function output() {
		echo $this->content;
	}
}

class Methods {
	public static function authorize() {
		if ((!isset($_SESSION['token'])) || (!isset($_SESSION['current_user']))) {
			header('Location: login');
			exit();
		}
	}

	public static function snip($beginning, $end, $string) {
		$beginningPos = strpos($string, $beginning);
		$endPos = strpos($string, $end);
		if ($beginningPos === false || $endPos === false) {
			return $string;
		}
		$textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);
		return str_replace($textToDelete, "", $string);
	}

	public static function getIdFromName($username) {
		global $db;

		$st = $db->prepare("SELECT `id` FROM `users` WHERE `username`=:username LIMIT 1");
		$st->bindParam(":username", $username);
		$st->execute();

		$r = $st->fetch(PDO::FETCH_ASSOC);
		$id = $r['id'];

		return $id;
	}
}
