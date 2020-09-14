<!DOCTYPE html>
<!--
	Unit 5: File Upload
	Tanner Babcock
	September 13, 2020
-->
<html lang="en">
<head>
	<title>Unit 5: File Upload</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="icon" type="image/png" href="/images/favicon.png" />
</head>
<body>
<?php
	if (!empty($_POST)) {
		if ((isset($_FILES['image'])) && ($_FILES['image']['error'] == 0)) {
			$filename  = $_FILES['image']['name'];
			$filetype = $_FILES['image']['type'];
			$filesize = $_FILES['image']['size'];

			$ext = pathinfo($filename, PATHINFO_EXTENSION);

			if (!array_key_exists($ext, ["jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png"])) {
				echo "<p class=\"error\">Filetype not allowed</p>";
			}
			if ($filesize > (5 * 1024 * 1024)) {
				echo "<p class=\"error\">Filesize is larger than allowed.</p>";
			}
			if (in_array($filetype, ["jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png"])) {
				if (file_exists(__DIR__ . "/upload/" . $filename)) {
					echo "<p class=\"error\">Filename already exists.</p>";
				}
				else {
					move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/upload/" . $filename);
					echo "<p class=\"success\">{$filename} was uploaded successfully!</p>";
					echo "<center class=\"imgOutput\"><img src=\"upload/" . $filename . "\" /></center>";
				}
			}
		}
		else if ($_FILES['image']['error'] == 4) {
			echo "<p class=\"error\">No file selected for upload.</p>";
		}
		else {
			echo "<p class=\"error\">Error: " . $_FILES['image']['error'] . "</p>";
		}
	}
?>
	<div class="box">
		<h1>File Upload Form</h1>
		<form action="./unit5files" method="post" enctype="multipart/form-data">
			<p>
				<label>Upload a file here: </label>
				<input type="file" name="image" id="fileUpload" />
			</p>
			<p><input type="submit" name="submit" value="Submit" /></p>
		</form>
	</div>
	<br />
	<center>
		<a href="/homework/index">&rarr; Return to WDV341 Homework &larr;</a> &bull;
		 <a href="https://github.com/Babkock/homework/blob/master/wdv341/unit5files.php" target="_blank">View Source Code</a>
	</center>
</body>
</html>
