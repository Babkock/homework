<?php
/*
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock
*/

/* This file is exclusively for responding to AJAX. All of the output will be rendered into the Editor's DOM */
if (!empty($_POST)) {
	if ((isset($_FILES['image'])) && ($_FILES['image']['error'] == 0)) {
		$filename = $_POST['fname'];
		$filetype = $_FILES['image']['type'];
		$filesize = $_FILES['image']['size'];

		$validtypes = [
			"jpg" => "image/jpg",
			"jpeg" => "image/jpeg",
			"png" => "image/png",
			"gif" => "image/gif"
		];

		$ext = pathinfo($filename, PATHINFO_EXTENSION);

		if (!array_key_exists($ext, $validtypes)) {
			echo "<p class=\"error\">That file type is not allowed. Only JPEG, PNG, and GIF images are allowed.</p>";
		}
		if ($filesize > (2 * 1024 * 1024)) {
			echo "<p class=\"error\">The file you selected is too big. Maximum size is 2 MB.</p>";
		}
		if (in_array($filetype, $validtypes)) {

			if (file_exists(__DIR__ . "/img/" . $filename)) {
				echo "<p class=\"error\">Filename already exists. Please choose a different name.</p>";
			}
			else {
				move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/img/" . $filename);
				echo "<center><img src=\"img/" . $filename . "\" /></center>";
			}
		}
	}
	else if ($_FILES['image']['error'] == 4) {
		echo "<p class=\"error\">No image selected for uploading.</p>";
	}
	else {
		echo "<p class=\"error\">Error: " . $_FILES['image']['error'] . "</p>";
	}
}
else {
	echo "<p class=\"error\">No image selected for uploading.</p>";
}

