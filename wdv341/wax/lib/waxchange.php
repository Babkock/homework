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
			if (strcmp($k, "tracklist") == 0) { $this->tracklist = $v; }
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

	public function read($id = 0) {

	}

	public function write($id = 0) {
		
	}
}

class User {
	private $id;
	private $username;
	private $password;
	private $email;

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

	public function output() {
		echo $this->content;
	}
}

class Methods {
	public static function authorize() {
		if (!isset($_SESSION['token'])) {
			header('Location: login');
			exit();
		}
		if (strcmp($_SESSION['token'], hash("sha256", $passkey)) != 0) {
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


}
