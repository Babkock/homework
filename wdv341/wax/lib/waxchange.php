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

	_______________________________________________________________________________________________________
	| year        | INT(11)      | The year the album was released.                                       |
	|-------------|--------------|------------------------------------------------------------------------|
	| condition   | VARCHAR(3)   | The physical condition of the album, from "m" (Mint) to "p" (Poor).    |
	|-------------|--------------|------------------------------------------------------------------------|
	| currency    | VARCHAR(3)   | The currency the seller expects to be paid in.                         |
	|-------------|--------------|------------------------------------------------------------------------|
	| purchased   | DATE         | The date the album was purchased.                                      |
	|-------------|--------------|------------------------------------------------------------------------|
	| sellerid    | INT(11)      | The user ID of the seller.                                             |
	|-------------|--------------|------------------------------------------------------------------------|
	| buyerid     | INT(11)      | The user ID of the buyer.                                              |
	|_____________|______________|________________________________________________________________________|
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
	/*
	private $year;
	private $condition;
	private $currency;
	private $purchased;
	private $sellerid;
	private $buyerid;
	*/

	public function __construct($id = 0) {
		if (strcmp(gettype($id), "integer") != 0) {
			exit("<p class=\"error\">First argument of new Album() must be integer</p>");
		}
		$this->id = $id;
	}

	public function getId() { return $this->id; }
	public function getArtist() { return $this->artist; }
	public function setArtist($a) {
		if (strlen($a) > 90) {
			exit("<p class=\"error\">Artist is too long, must be 90 characters or less.</p>");
		}
		$this->artist = $a;
	}
	public function getTitle() { return $this->title; }
	public function setTitle($b) {
		if (strlen($b) > 90) {
			exit("<p class=\"error\">Title is too long, must be 90 characters or less.</p>");
		}
		$this->title = $b;
	}
	public function getMedia() { return $this->media; }
	public function setMedia($m) { $this->media = $m; }
	public function getDiscs() { return $this->discs; }
	public function setDiscs($d) { $this->discs = $d; }
	public function getTracklist() { return $this->tracklist; }
	public function setTracklist($t) { $this->tracklist = $t; }
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
	/*
	public function getYear() { return $this->year; }
	public function setYear($y) { $this->year = $y; }
	public function getCondition() { return $this->condition; }
	public function setCondition($c) {
		if ((strlen($c) > 3) || (strlen($c) < 1)) {
			exit("<p class=\"error\">Condition field must be at least 1, and no more than 3 characters.</p>");
		}
		$this->condition = $c;
	}
	public function getCurrency() { return $this->currency; }
	public function setCurrency($c) { $this->currency = $c; }
	public function getPurchased() { return $this->purchased; }
	public function setPurchased($p) { $this->purchased = $p; }
	public function getSellerId() { return $this->sellerid; }
	public function setSellerId($s) { $this->seller = $s; }
	public function getBuyerId() { return $this->buyerid; }
	public function setBuyerId($b) { $this->buyerid = $b; }
	*/

	public function seta($arr) {
		foreach ($arr as $k => $v) {
			if (strcmp($k, "artist") == 0) { $this->artist = $v; }
			if (strcmp($k, "title") == 0) { $this->setTitle($v); }
			if (strcmp($k, "media") == 0) { $this->media = $v; }
			if (strcmp($k, "discs") == 0) { $this->setDiscs($v); }
			if (strcmp($k, "price") == 0) { $this->price = $v; }			
			if (strcmp($k, "seller") == 0) { $this->seller = $v; }
			if (strcmp($k, "buyer") == 0) { $this->buyer = $v; }
			if (strcmp($k, "image") == 0) { $this->image = $v; }
			if (strcmp($k, "label") == 0) { $this->label = $v; }
			if (strcmp($k, "posted") == 0) { $this->setPosted($v); }
			if (strcmp($k, "country") == 0) { $this->country = $v; }
			if (strcmp($k, "tracklist") == 0) {
				$this->tracklist = [];
				$tl = json_decode($v);

				foreach ($tl as $track) {
					array_push($this->tracklist, [$track->title, $track->length]);
				}
			}
			/*
			if (strcmp($k, "year") == 0) { $this->year = $v; }
			if (strcmp($k, "condition") == 0) { $this->condition = $v; }
			if (strcmp($k, "currency") == 0) { $this->currency = $v; }
			if (strcmp($k, "purchased") == 0) { $this->purchased = $v; }
			if (strcmp($k, "sellerid") == 0) { $this->sellerid = $v; }
			if (strcmp($k, "buyerid") == 0) { $this->buyerid = $v; }
			*/
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
		$arr['seller'] = $this->seller;
		$arr['buyer'] = $this->buyer;
		$arr['image'] = $this->image;
		$arr['label'] = $this->label;
		$arr['posted'] = $this->posted;
		$arr['country'] = $this->country;
		$arr['tracklist'] = $this->tracklist;
		/*
		$arr['year'] = $this->year;
		$arr['condition'] = $this->condition;
		$arr['currency'] = $this->currency;
		$arr['purchased'] = $this->purchased;
		$arr['sellerid'] = $this->sellerid;
		$arr['buyerid'] = $this->buyerid;
		*/
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
		$this->seller = $b->seller;
		$this->buyer = $b->buyer;
		$this->image = $b->image;
		$this->label = $b->label;
		$this->posted = $b->posted;
		$this->country = $b->country;
		$this->tracklist = [];
		/*
		$this->year = $b->year;
		$this->condition = $b->condition;
		$this->currency = $b->currency;
		$this->purchased = $b->purchased;
		$this->sellerid = $b->sellerid;
		$this->buyerid = $b->buyerid;
		*/

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
		$this->seta([
			"artist" => $row['artist'],
			"title" => $row['title'],
			"media" => $row['media'],
			"discs" => $row['discs'],
			"price" => $row['price'],
			"seller" => $row['seller'],
			"buyer" => $row['buyer'],
			"image" => $row['image'],
			"label" => $row['label'],
			"posted" => $row['posted'],
			"country" => $row['country'],
			"tracklist" => $row['tracklist']
			/*
			"year" => $row['year'],
			"condition" => $row['condition'],
			"currency" => $row['currency'],
			"purchased" => $row['purchased'],
			"sellerid" => $row['sellerid'],
			"buyerid" => $row['buyerid']
			*/
		]);
	}

	public function write() {
		global $db;

		$st = $db->prepare("INSERT INTO `albums` VALUES (id, :artist, :title, :media, :discs, :price, :seller, :buyer, :image, :label, NOW(), :country, :tracklist)");
		// $st = $db->prepare("INSERT INTO `albums` VALUES (id, :artist, :title, :media, :discs, :price, :seller, NULL, :image, :label, NOW(), :country, :tracklist, :year, :condition, :currency, :releasetype, :sellerid, NULL)");
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
		/*
		$st->bindParam(":year", $this->year);
		$st->bindParam(":condition", $this->condition);
		$st->bindParam(":currency", $this->currency);
		$st->bindParam(":sellerid", $this->sellerid);
		$st->bindParam(":buyerid", $this->buyerid);
		*/

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

		$st = $db->prepare("UPDATE `albums` SET `artist`=:artist, `title`=:title, `media`=:media, `discs`=:discs, `price`=:price, `seller`=:seller, `buyer`=:buyer, `image`=:image, `label`=:label, `posted`=:posted, `country`=:country, `tracklist`=:tracklist WHERE `id`=:id LIMIT 1");
		// $st = $db->prepare("UPDATE `albums` SET `artist`=:artist, `title`=:title, `media`=:media, `discs`=:discs, `price`=:price, `seller`=:seller, `buyer`=:buyer, `image`=:image, `label`=:label, `posted`=posted, `country`=:country, `tracklist`=:tracklist, `year`=:year, `condition`=:condition, `currency`=:currency, `purchased`=:purchased, `sellerid`=:sellerid, `buyerid`=:buyerid WHERE `id`=:id LIMIT 1");
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
		$st->bindParam(":posted", $this->posted);
		$st->bindParam(":country", $this->country);
		/*
		$st->bindParam(":year", $this->year);
		$st->bindParam(":condition", $this->condition);
		$st->bindParam(":currency", $this->currency);
		$st->bindParam(":purchased", $this->purchased);
		$st->bindParam(":sellerid", $this->sellerid);
		$st->bindParam(":buyerid", $this->buyerid);
		*/

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

	public function purchase($buyer) {
		global $db;

		$bid = Methods::getIdFromName($buyer);
		$this->setBuyer($buyer);
		// $this->setBuyerId($bid);
		$this->update();
	}

	public static function delete($id = 0) {
		global $db;

		$st = $db->prepare("DELETE FROM `albums` WHERE `id`=:id LIMIT 1");
		$st->bindParam(":id", $id);
		$st->execute();
	}
} /* class Album */

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

	_________________________________________________________________________________________
	| image       | VARCHAR(50)  | The image URL of the user's avatar.                      |
	|-------------|--------------|----------------------------------------------------------|
	| biography   | TEXT         | The user's custom biography.                             |
	|-------------|--------------|----------------------------------------------------------|
	| registered  | DATE         | The date the user registered.                            |
	|-------------|--------------|----------------------------------------------------------|
	| showemail   | INT(11)      | The user's preference on public email visibility, (0-2). |
	|_____________|______________|__________________________________________________________|
*/

class User {
	private $id;
	private $username;
	private $password;
	private $email;
	private $country;
	/*
	private $image;
	private $biography;
	private $registered;
	private $showemail;
	*/

	public function __construct($id = 0) {
		if (strcmp(gettype($id), "integer") != 0) {
			exit("<p class=\"error\">First argument of new User() must be an integer.</p>");
		}
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
	/*
	public function getImage() { return $this->image; }
	public function setImage($i) { $this->image = $i; }
	public function getBiography() { return $this->biography; }
	public function setBiography($b) { $this->biography = $b; }
	public function getRegistered() { return $this->registered; }
	public function setRegistered($r) { $this->registered = $r; }
	public function getShowEmail() { return $this->showemail; }
	public function setShowEmail($s) { $this->showemail = $s; }
	*/

	public function seta($arr) {
		foreach ($arr as $k => $v) {
			if (strcmp($k, "username") == 0) { $this->username = $v; }
			if (strcmp($k, "password") == 0) { $this->password = $v; }
			if (strcmp($k, "email") == 0) { $this->email = $v; }
			if (strcmp($k, "country") == 0) { $this->country = $v; }
			/*
			if (strcmp($k, "image") == 0) { $this->image = $v; }
			if (strcmp($k, "biography") == 0) { $this->biography = $v; }
			if (strcmp($k, "registered") == 0) { $this->registered = $v; }
			if (strcmp($k, "showemail") == 0) { $this->showemail = $v; }
			*/
		}
	}

	public function geta() {
		$arr = [];
		$arr['id'] = $this->id;
		$arr['username'] = $this->username;
		$arr['password'] = $this->password;
		$arr['email'] = $this->email;
		$arr['country'] = $this->country;
		/*
		$arr['image'] = $this->image;
		$arr['biography'] = $this->biography;
		$arr['registered'] = $this->registered;
		$arr['showemail'] = $this->showemail;
		*/
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
		// $st = $db->prepare("INSERT INTO `users` VALUES (id, :username, :password, :email, :country, :image, :biography, NOW(), 0)");
		$st->bindParam(":username", $this->username);
		$st->bindParam(":password", $this->password);
		$st->bindParam(":email", $this->email);
		$st->bindParam(":country", $this->country);
		/*
		$st->bindParam(":image", $this->image);
		$st->bindParam(":biography", $this->biography);
		*/
		$st->execute();
	}

	public function update() {
		global $db;

		$st = $db->prepare("UPDATE `users` SET `username`=:username, `password`=:password, `email`=:email, `country`=:country WHERE `id`=:id LIMIT 1");
		// $st = $db->prepare("UPDATE `users` SET `username`=:username, `password`=:password, `email`=:email, `country`=:country, `image`=:image, `biography`=:biography, `registered`=registered, `showemail`=:showemail");
		$st->bindParam(":id", $this->id);
		$st->bindParam(":username", $this->username);
		$st->bindParam(":password", $this->password);
		$st->bindParam(":email", $this->email);
		$st->bindParam(":country", $this->country);
		/*
		$st->bindParam(":image", $this->image);
		$st->bindParam(":biography", $this->biography);
		$st->bindParam(":showemail", $this->showemail);
		*/
		$st->execute();
	}

	public static function delete($id = 0) {
		global $db;

		$st = $db->prepare("DELETE FROM `users` WHERE `id`=:id LIMIT 1");
		$st->bindParam(":id", $id);
		$st->execute();
	}
} /* class User */

class Page {
	private $header;
	private $content;
	private $footer;
	private $title;

	public function __construct($head, $cont) {
		if (!isset($head) || !isset($cont)) {
			exit("<p class=\"error\">No file for loading</p>");
		}
		$this->header = file_get_contents(__DIR__ . "/../views/{$head}.html");
		$this->content = file_get_contents(__DIR__ . "/../views/{$cont}.html");
		$this->footer = file_get_contents(__DIR__ . "/../views/footer.html");
	}

	public function getHeader() { return $this->header; }
	public function setHeader($h) { $this->header = $h; }
	public function getContent() { return $this->content; }
	public function setContent($c) { $this->content = $c; }
	public function getFooter() { return $this->footer; }
	public function setFooter($f) { $this->footer = $f; }
	public function getTitle() { return $this->title; }
	public function setTitle($t) {
		$this->title = $t;
		$this->hreplace("TITLE", $t);
	}
	public function setDescription($d) {
		$this->hreplace("DESCRIPTION", $d);
	}

	public function replace($plchold, $val = "") {
		$this->content = str_replace("{{" . $plchold . "}}", $val, $this->content);
	}

	public function replacea($arr) {
		foreach ($arr as $k => $v) {
			$this->content = str_replace("{{" . $k . "}}", $v, $this->content);
		}
	}

	public function hreplace($plchold, $val = "") {
		$this->header = str_replace("{{" . $plchold . "}}", $val, $this->header);
	}

	public function hreplacea($arr) {
		foreach ($arr as $k => $v) {
			$this->header = str_replace("{{" . $k . "}}", $v, $this->header);
		}
	}

	public function error($message) {
		$this->header = "";
		$this->footer = "";
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
		$this->output();
	}

	public function script($s) {
//		$this->content = str_replace("\t</body>\n</html>", "\t\t<script>" . file_get_contents(__DIR__ . "/../../../assets/js/" . $s) . "</script>\n\t</body>\n</html>", $this->content);
		$this->content = $this->content . "\n<script>" . file_get_contents(__DIR__ . "/../../../assets/js/" . $s) . "</script>\n";
	}

	public function output() {
		echo $this->header . $this->content . $this->footer;
	}
} /* class Page */

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

	public static function countryExpand($c) {
		$ct = "";
		switch ($c) {
			case "us":
				$ct = "United States"; break;
			case "ca":
				$ct = "Canada"; break;
			case "mx":
				$ct = "Mexico"; break;
			case "ru":
				$ct = "Russian Federation"; break;
			case "uk":
				$ct = "United Kingdom"; break;
			case "ie":
				$ct = "Ireland"; break;
			case "fr":
				$ct = "France"; break;
			case "es":
				$ct = "Spain"; break;
			case "de":
				$ct = "Germany"; break;
			case "pl":
				$ct = "Poland"; break;
			case "lx":
				$ct = "Luxembourg"; break;
			case "dk":
				$ct = "Denmark"; break;
			case "se":
				$ct = "Sweden"; break;
			case "no":
				$ct = "Norway"; break;
			case "fl":
				$ct = "Finland"; break;
			case "au":
				$ct = "Australia"; break;
			case "nl":
				$ct = "Netherlands"; break;
			case "it":
				$ct = "Italy"; break;
			case "lv":
				$ct = "Latvia"; break;
			case "cn":
				$ct = "China"; break;
			case "jp":
				$ct = "Japan"; break;
			case "ph":
				$ct = "Philippines"; break;
			case "kr":
				$ct = "South Korea"; break;
			case "cz":
				$ct = "Czech Republic"; break;
			case "br":
				$ct = "Brazil"; break;
			case "is":
				$ct = "Iceland"; break;
			case "am":
				$ct = "Armenia"; break;
			case "az":
				$ct = "Azerbaijan"; break;
			case "ch":
				$ct = "Switzerland"; break;
			case "at":
				$ct = "Austria"; break;
			case "ua":
				$ct = "Ukraine"; break;
			case "tr":
				$ct = "Turkey"; break;
			case "ba":
				$ct = "Bosnia and Herzegovina"; break;
			case "in":
				$ct = "India"; break;
			case "hu":
				$ct = "Hungary"; break;
			case "ro":
				$ct = "Romania"; break;
			default:
				$ct = "Unknown Country"; break;
		}
		return $ct;
	}

	public static function currencyExpand($c) {

	}

	public static function conditionExpand($c) {

	}
} /* class Methods */
