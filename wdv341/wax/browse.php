<?php
/*
	browse.php

	WaXchange PHP Project
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require_once("lib/waxchange.php");

try {
	if (!empty($_POST)) {
		/* ajax responder */
		header('Content-Type: application/json');

		if (!isset($_GET['mode'])) {
			if (!isset($_GET['id'])) {
				exit("{ \"error\": \"No mode or id specified\" }");
			}
			else {
				$st = $db->prepare("SELECT * FROM `albums` WHERE `id`=:id LIMIT 1");
				$st->bindParam(":id", $_GET['id']);
			}
		}
		else {
			if (strcmp($_GET['mode'], "newest") == 0) {
				$st = $db->prepare("SELECT * FROM `albums` ORDER BY `posted` DESC LIMIT 6");
			}
			else if (strcmp($_GET['mode'], "expensive") == 0) {
				$st = $db->prepare("SELECT * FROM `albums` ORDER BY `price` DESC LIMIT 6");
			}
			else if (strcmp($_GET['mode'], "purchased") == 0) {
				$st = $db->prepare("SELECT * FROM `albums` WHERE `buyer`=:buyer ORDER BY `purchased` DESC LIMIT 6");
				$buyer = $_SESSION['current_user'];
				$st->bindParam(":buyer", $buyer);
			}
			else if (strcmp($_GET['mode'], "artist") == 0) {
				if (!isset($_GET['a'])) {
					exit("{ \"error\": \"The artist mode must have an additional 'a' argument\" }");
				}
				$st = $db->prepare("SELECT * FROM `albums` WHERE `artist`=:artist ORDER BY `year` DESC");
				$artist = ucwords($_GET['a']);

				$st->bindParam(":artist", $artist);
			}
			else if (strcmp($_GET['mode'], "album") == 0) {
				if (!isset($_GET['b'])) {
					exit("{ \"error\": \"The album mode must have an additional 'b' argument\" }");
				}
				$st = $db->prepare("SELECT * FROM `albums` WHERE `title`=:title ORDER BY `price` DESC");
				
				$title = ucwords($_GET['b']);
				$st->bindParam(":title", $title);
			}
			else if (strcmp($_GET['mode'], "country") == 0) {
				if (!isset($_GET['c'])) {
					exit("{ \"error\": \"The country mode must have an additional 'c' argument\" }");
				}
				if (strlen($_GET['c']) > 2) {
					exit("{ \"error\": \"The c argument must be only 2 characters\" }");
				}
				$st = $db->prepare("SELECT * FROM `albums` WHERE `country`=:country ORDER BY `posted` DESC");
				$st->bindParam(":country", $_GET['c']);
			}
			else {
				/* assume newest */
				$st = $db->prepare("SELECT * FROM `albums` ORDER BY `posted` DESC");
			}
			$st->execute();

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
					"year": {$row['year']},
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
		$sscript = <<<EOF
<script>
var app = new Vue({
	el: "#browse",

	methods: {
		BuyAlbum(i) {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/buy?id=" + i;
		},

		EditAlbum(i) {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/album?id=" + i;
		},

		Register() {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/register";
		}
	}

});
</script>
EOF;

		/* show a normal page */
		if (!isset($_SESSION['current_user'])) {
			/* not logged in */
			
			if (isset($_GET['a'])) {       // artist
				$browse = new Page("header_guest", "browse_specific");
				$browse->script("waxBrowse.min.js");
				$browse->ogImage("https://tannerbabcock.com/homework/wdv341/wax/img/bigbg.jpg");
				$artist = ucwords($_GET['a']);

				$heading = "Artist: " . $artist;

				$browse->replacea([
					"USERID" => "0",
					"HEADING" => $heading,
					"BROWSE_ARTIST" => $artist,
					"BROWSE_ALBUM" => "",
					"BROWSE_COUNTRY" => $_GET['c'] ?? "",
					"BROWSE_GET" => "a",
					"BROWSE_GET_VALUE" => $_GET['a'],
					"BUYBUTTON" => "<button v-if=\"al.buyer === ''\" class=\"buy\" @click=\"Register()\">Buy This Album</button>"
				]);

				$browse->setTitle($artist . " &bull; WaXchange");
				$browse->setDescription("The WaXchange artist page for " . $artist . ". This shows all releases, all sellers, from all countries. WaXchange is a new music marketplace.");
			}
			else if (isset($_GET['b'])) {  // album
				$browse = new Page("header_guest", "browse_specific");
				$browse->script("waxBrowse.min.js");
				$browse->ogImage("https://tannerbabcock.com/homework/wdv341/wax/img/bigbg.jpg");
				$album = ucwords($_GET['b']);

				$heading = "<i>" . $album . "</i>";
				
				$browse->replacea([
					"USERID" => "0",
					"HEADING" => $heading,
					"BROWSE_ARTIST" => "",
					"BROWSE_ALBUM" => $album,
					"BROWSE_COUNTRY" => $_GET['c'] ?? "",
					"BROWSE_GET" => "b",
					"BROWSE_GET_VALUE" => $_GET['b'],
					"BUYBUTTON" => "<button v-if=\"al.buyer === ''\" class=\"buy\" @click=\"Register()\">Buy This Album</button>"
				]);

				$browse->setTitle($album . " &bull; WaXchange");
				$browse->setDescription("All listings of " . $album . " on WaXchange. This page includes all sellers, from all countries. WaXchange is a new music marketplace.");
			}
			else if (isset($_GET['c'])) {  // country
				$browse = new Page("header_guest", "browse_specific");
				$browse->script("waxBrowse.min.js");
				$browse->ogImage("https://tannerbabcock.com/homework/wdv341/wax/img/bigbg.jpg");
				$country = Methods::countryExpand($_GET['c']);

				$browse->replacea([
					"USERID" => "0",
					"HEADING" => "Country: " . $country,
					"BROWSE_ARTIST" => "",
					"BROWSE_ALBUM" => "",
					"BROWSE_COUNTRY" => $_GET['c'],
					"BROWSE_GET" => "c",
					"BROWSE_GET_VALUE" => $_GET['c'],
					"BUYBUTTON" => "<button v-if=\"al.buyer === ''\" class=\"buy\" @click=\"Register()\">Buy This Album</button>"
				]);

				$browse->setTitle("WaXchange &bull; " . $country . " Market");
				$browse->setDescription("All WaXchange releases for sale from " . $country . ". This page includes all releases.");
			}
			else {
				/* showing a single album */
				if (isset($_GET['id'])) {
					$browse = new Page("header_guest", "browse_specific");
					$browse->replacea([
						"USERID" => "0",
						"HEADING" => "Album #" . $_GET['id'],
						"BROWSE_ARTIST" => "",
						"BROWSE_ALBUM" => "",
						"BROWSE_COUNTRY" => "",
						"BROWSE_GET" => "id",
						"BROWSE_GET_VALUE" => $_GET['id'],
						"BUYBUTTON" => "<button v-if=\"al.buyer === ''\" class=\"buy\" @click=\"Register()\">Buy This Album</button>"
					]);

					$browse->replace("BROWSE_GET_VALUE");
					$browse->setTitle("WaXchange &bull; Album #" . $_GET['id']);

					$st = $db->prepare("SELECT * FROM `albums` WHERE `id`=:id");
					$st->bindParam(":id", intval($_GET['id']));
					$st->execute();

					$row = $st->fetch(PDO::FETCH_ASSOC);
					$browse->ogImage("https://tannerbabcock.com/homework/wdv341/wax/" . $row['image']);

					$country = Methods::countryExpand($row['country']);

					$browse->setDescription("WaXchange album #" . $_GET['id'] . ": " . $row['artist'] . " - " . $row['title'] . ", for sale from " . $row['seller'] . " in " . $country . ". This is an individual listing.");
					$tl = json_decode($row['tracklist']);
					$tlout = "<table class=\"track-list\"><tbody>";
					$x = 1;

					foreach ($tl as $k => $v) {
						$tlout .= <<<EOF
						<tr>
							<td>{$x}.</td>
							<td>{$v->title}</td>
							<td>{$v->length}</td>
						</tr>
EOF;
						$x++;
					}

					$tlout .= "</tbody></table>";
					$posted = date("F j, Y", strtotime($row['posted']));

					if (strlen($row['purchased']) > 1) {
						$purchased = date("F j, Y", strtotime($row['purchased']));
						$prow = <<<EOF
					<div class="alb-info">
						<div class="prop">
							Date Purchased:
						</div>
						<div class="val">
							<b>{$purchased}</b>
						</div>
					</div>
EOF;
					}
					else {
						$prow = "";
					}

					$price = number_format((float)$row['price'], 2, ".", "");
					$sprice = Methods::currencySymbol($row['currency']) . $price;
					$condition = Methods::conditionExpand($row['cond']);
					$encodealbum = urlencode($row['title']);
					$encodeartist = urlencode($row['artist']);

					if (strlen($row['buyer']) > 1) {
						$sellbuy = "<h3>Sold for <span class=\"price\">" . $sprice . "</span> to <a href=\"user?id=" . $row['buyerid'] . "\">" . $row['buyer'] . "</a></h3>";
						$buybutton = "";
					}
					else {
						$sellbuy = "<h3><span class=\"price\">" . $sprice . "</span> from <a href=\"user?id=" . $row['sellerid'] . "\">" . $row['seller'] . "</a></h3>";
						$buybutton = "<button class=\"buy\" @click=\"BuyAlbum(" . $row['id'] . ")\">Buy This Album</button>";
					}

					$out = <<<EOF
<main id="browse">
	<div class="albums-box">
		<div class="album" style="width:100%;">
			<div class="cover" style="width:40%; margin-left:30%; margin-right:30%;">
				<img src="{$row['image']}" />
			</div>
			<h2><a href="browse?a={$encodeartist}">{$row['artist']}</a> - <i><a href="browse?b={$encodealbum}">{$row['title']}</a></i></h2>
			<div>
				<h2>{$row['discs']} x <span class="media">{$row['media']}</span></h2>
				{$sellbuy}
				{$buybutton}
				<div class="alb-info">
					<div class="prop">
						Condition:
					</div>
					<div class="val">
						<b>{$condition}</b>
					</div>
				</div>
				<div class="alb-info">
					<div class="prop">
						Year:
					</div>
					<div class="val">
						<b>{$row['year']}</b>
					</div>
				</div>
				<div class="alb-info">
					<div class="prop">
						Country:
					</div>
					<div class="val">
						<b>{$country}</b>
					</div>
				</div>
				<div class="alb-info">
					<div class="prop">
						Date Posted:
					</div>
					<div class="val">
						<b>{$posted}</b>
					</div>
				</div>
				{$prow}
				<h3>Tracklist:</h3>
				{$tlout}
				<p><b>&copy; &copysr; {$row['year']} {$row['label']}</b></p>
			</div>
		</album>
	</div>
</main>
{$sscript}
EOF;

					$browse->setContent($out);

				}
				else {
					$browse = new Page("header_guest", "browse");
					$browse->setContent(Methods::snip("{{IF_LOGGED_IN}}", "{{ENDIF}}", $browse->getContent()));

					$browse->script("waxBrowse.min.js");
					$browse->ogImage("https://tannerbabcock.com/homework/wdv341/wax/img/bigbg.jpg");
					$browse->replacea([
						"USERID" => "0",
						"HEADING" => "",
						"BROWSE_ARTIST" => "",
						"BROWSE_ALBUM" => "",
						"BROWSE_COUNTRY" => "",
						"BROWSE_GET" => "",
						"BROWSE_GET_VALUE" => "",
						"BUYBUTTON" => "<button v-if=\"al.buyer === ''\" class=\"buy\" @click=\"Register()\">Buy This Album</button>"
					]);

					$browse->setTitle("WaXchange &bull; Browse");
					$browse->setDescription("Browsing the newest, most expensive, and trending releases on the WaXchange marketplace.");
				}
			}
		}
		else {
			/* logged in */
			$uid = Methods::getIdFromName($_SESSION['current_user']);

			if (isset($_GET['a'])) {    // artist
				$browse = new Page("header_user", "browse_specific");
				$browse->replace("IF_LOGGED_IN");
				$browse->replace("ENDIF");
				$browse->script("waxBrowse.min.js");
				$browse->ogImage("https://tannerbabcock.com/homework/wdv341/wax/img/bigbg.jpg");
				$browse->hreplace("USERID", "" . $uid);
				$artist = ucwords($_GET['a']);

				$heading = "Artist: " . $artist;
				
				$browse->replacea([
					"USERID" => "" . $uid,
					"HEADING" => $heading,
					"BROWSE_ARTIST" => $artist,
					"BROWSE_ALBUM" => "",
					"BROWSE_COUNTRY" => $_GET['c'] ?? "",
					"BROWSE_GET" => "a",
					"BROWSE_GET_VALUE" => $_GET['a'],
					"BUYBUTTON" => "<button v-if=\"al.buyer === ''\" class=\"buy\" @click=\"BuyAlbum(al.id)\">Buy This Album</button>"
				]);

				$browse->setTitle($artist . " &bull; WaXchange");
				$browse->setDescription("The WaXchange artist page for " . $artist . ". This shows all releases, all sellers, from all countries. WaXchange is a new music marketplace.");
			}
			else if (isset($_GET['b'])) {    // album
				$browse = new Page("header_user", "browse_specific");
				$browse->script("waxBrowse.min.js");
				$browse->ogImage("https://tannerbabcock.com/homework/wdv341/wax/img/bigbg.jpg");
				$browse->hreplace("USERID", "" . $uid);
				$album = ucwords($_GET['b']);

				$heading = "<i>" . $album . "</i>";
				
				$browse->replacea([
					"USERID" => "" . $uid,
					"HEADING" => $heading,
					"BROWSE_ARTIST" => "",
					"BROWSE_ALBUM" => $_GET['b'],
					"BROWSE_COUNTRY" => $_GET['c'] ?? "",
					"BROWSE_GET" => "b",
					"BROWSE_GET_VALUE" => $_GET['b'],
					"BUYBUTTON" => "<button v-if=\"al.buyer === ''\" class=\"buy\" @click=\"BuyAlbum(al.id)\">Buy This Album</button>"
				]);

				$browse->setTitle($_GET['b'] . " &bull; WaXchange");
				$browse->setDescription("All listings of " . $_GET['b'] . " on WaXchange. This page includes all sellers, from all countries. WaXchange is a new music marketplace.");
			}
			else if (isset($_GET['c'])) {   // country
				$browse = new Page("header_user", "browse_specific");
				$browse->script("waxBrowse.min.js");
				$browse->ogImage("https://tannerbabcock.com/homework/wdv341/wax/img/bigbg.jpg");
				$country = Methods::countryExpand($_GET['c']);

				$browse->hreplace("USERID", "" . $uid);
				$browse->replacea([
					"USERID" => "" . $uid,
					"HEADING" => "Country: " . $country,
					"BROWSE_ARTIST" => "",
					"BROWSE_ALBUM" => "",
					"BROWSE_COUNTRY" => $_GET['c'],
					"BROWSE_GET" => "c",
					"BROWSE_GET_VALUE" => $_GET['c'],
					"BUYBUTTON" => "<button v-if=\"al.buyer === ''\" class=\"buy\" @click=\"BuyAlbum(al.id)\">Buy This Album</button>"
				]);

				$browse->setTitle("WaXchange &bull; " . $country . " Market");
				$browse->setDescription("All WaXchange releases for sale from " . $country . ". This page includes all releases.");
			}
			else {
				/* showing a single album */
				if (isset($_GET['id'])) {
					$browse = new Page("header_user", "browse_specific");
					$browse->hreplace("USERID", "" . $uid);
					$browse->replacea([
						"USERID" => "" . $uid,
						"HEADING" => "Album #" . $_GET['id'],
						"BROWSE_ARTIST" => "",
						"BROWSE_ALBUM" => "",
						"BROWSE_COUNTRY" => "",
						"BROWSE_GET" => "id",
						"BROWSE_GET_VALUE" => $_GET['id']
					]);

					$browse->setTitle("WaXchange &bull; Album #" . $_GET['id']);

					$st = $db->prepare("SELECT * FROM `albums` WHERE `id`=:id");
					$st->bindParam(":id", intval($_GET['id']));
					$st->execute();

					$row = $st->fetch(PDO::FETCH_ASSOC);
					$browse->ogImage("https://tannerbabcock.com/homework/wdv341/wax/" . $row['image']);
					$country = Methods::countryExpand($row['country']);

					$browse->setDescription("WaXchange album #" . $_GET['id'] . ": " . $row['artist'] . " - " . $row['title'] . ", for sale from " . $row['seller'] . " in " . $country . ". This is an individual listing.");
					$tlout = "<table class=\"track-list\"><tbody>";
					$tl = json_decode($row['tracklist']);

					$x = 1;
					foreach ($tl as $k => $v) {
						$tlout .= <<<EOF
						<tr>
							<td>{$x}.</td>
							<td>{$v->title}</td>
							<td>{$v->length}</td>
						</tr>
EOF;
						$x++;
					}

					$tlout .= "</tbody></table>";

					$price = number_format((float)$row['price'], 2, ".", "");
					$sprice = Methods::currencySymbol($row['currency']) . $price;
					$condition = Methods::conditionExpand($row['cond']);

					if (strlen($row['purchased']) > 1) {
						$purchased = date("F j, Y", strtotime($row['purchased']));
						$prow = <<<EOF
				<div class="alb-info">
					<div class="prop">
						Date Purchased:
					</div>
					<div class="val">
						<b>{$purchased}</b>
					</div>
				</div>
EOF;
					}
					else {
						$prow = "";
					}
					
					$posted = date("F j, Y", strtotime($row['posted']));
					$encodealbum = urlencode($row['title']);
					$encodeartist = urlencode($row['artist']);

					if (strlen($row['buyer']) > 1) {
						$sellbuy = "<h3>Sold for <span class=\"price\">" . $sprice . "</span> to <a href=\"user?id=" . $row['buyerid'] . "\">" . $row['buyer'] . "</a></h3>";
						$buybutton = "";
					}
					else {
						$sellbuy = "<h3><span class=\"price\">" . $sprice . "</span> from <a href=\"user?id=" . $row['sellerid'] . "\">" . $row['seller'] . "</a></h3>";
						$buybutton = "<button class=\"buy\" @click=\"BuyAlbum(" . $row['id'] . ")\">Buy This Album</button>";
					}

					$out = <<<EOF
<main id="browse">
	<div class="albums-box">
		<div class="album" style="width:100%;">
			<div class="cover" style="width:40%; margin-left:30%; margin-right:30%;">
				<img src="{$row['image']}" />
			</div>
			<h2><a href="browse?a={$encodeartist}">{$row['artist']}</a> - <i><a href="browse?b={$encodealbum}">{$row['title']}</a></i></h2>
			<div>
				<h2>{$row['discs']} x <span class="media">{$row['media']}</span></h2>
				{$sellbuy}
				{$buybutton}
				<div class="alb-info">
					<div class="prop">
						Condition:
					</div>
					<div class="val">
						<b>{$condition}</b>
					</div>
				</div>
				<div class="alb-info">
					<div class="prop">
						Year:
					</div>
					<div class="val">
						<b>{$row['year']}</b>
					</div>
				</div>
				<div class="alb-info">
					<div class="prop">
						Country:
					</div>
					<div class="val">
						<b>{$country}</b>
					</div>
				</div>
				<div class="alb-info">
					<div class="prop">
						Date Posted:
					</div>
					<div class="val">
						<b>{$posted}</b>
					</div>
				</div>
				{$prow}
				<h3>Tracklist:</h3>
				{$tlout}
				<p><b>&copy; &copysr; {$row['year']} {$row['label']}</b></p>
			</div>
		</album>
	</div>
</main>
{$sscript}
EOF;

					$browse->setContent($out);

				}
				else {
					$browse = new Page("header_user", "browse");
					$browse->script("waxBrowse.min.js");
					$browse->ogImage("https://tannerbabcock.com/homework/wdv341/wax/img/bigbg.jpg");
					$browse->hreplace("USERID", "" . $uid);
					$browse->replacea([
						"USERID" => "0",
						"HEADING" => "",
						"BROWSE_ARTIST" => "",
						"BROWSE_ALBUM" => "",
						"BROWSE_COUNTRY" => "",
						"BROWSE_GET" => "",
						"BROWSE_GET_VALUE" => "",
						"BUYBUTTON" => "<button v-if=\"al.buyer === ''\" class=\"buy\" @click=\"BuyAlbum(al.id)\">Buy This Album</button>"
					]);

					$browse->setTitle("WaXchange &bull; Browse");
					$browse->setDescription("Browsing the newest, most expensive, and trending releases on the WaXchange marketplace.");
				}
			}
		}
		$browse->output();
	}
}
catch (PDOException $e) {
	exit("<p class=\"error\">Error: {$e->getMessage()}</p>");
}
