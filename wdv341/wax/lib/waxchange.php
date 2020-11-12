<?php

require_once("../../dbConnect.php");

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

	public function __construct($a = "Unknown Artist", $b = "Unknown Album") {
		if (strcmp(gettype($a), "string") != 0) {
			exit("<p class=\"error\">Error: First argument of new Album() not a string</p>");
		}
		if (strcmp(gettype($b), "string") != 0) {
			exit("<p class=\"error\">Error: Second argument of new Album() not a string</p>");
		}
		$this->artist = $a;
		$this->album = $b;
	}

	public function getId() { return $this->id; }
	public function setId($i) { $this->id = $i; }
	public function getArtist() { return $this->artist; }
	public function setArtist($a) { $this->artist = $a; }
	public function getTitle() { return $this->title; }
	public function setTitle($b) { $this->title = $b; }
	public function getMedia() { return $this->media; }
	public function setMedia($m) { $this->media = $m; }

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

	public function geta($arr) {

	}
}

class User {

}

