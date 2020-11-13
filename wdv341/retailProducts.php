<!DOCTYPE html>
<?php
/*
	Unit 8: PHP Formatted Output
	Tanner Babcock
	October 8, 2020
*/
require_once("dbConnect.php");
try {
?>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Unit 8: PHP Formatted Output</title>
	<link rel="icon" type="image/png" href="/images/favicon.png" />
	<style>
		body {
			background:linear-gradient(darkblue, #103d3d);
			color:white;
			font-size:1.08em;
		}
		main {
			width:98%;
			margin-left:1%;
			margin-right:1%;
			padding:2px;
			display:flex;
			flex-wrap:wrap;
			flex-direction:row;
			justify-content:center;
		}
		a, a:link, a:visited, a:active {
			color:lightblue;
		}
		a:hover {
			color:lime;
		}

		.productBlock {
			width:22%;
			margin-left:1%;
			margin-right:1%;
			margin-top:20px;
			background: rgba(60, 15, 10, 0.3);
			font-size:1.09em;
			color:#dfdfdf;
			padding:4px;
			padding-top:5px;
			border:1px solid lightblue;
			transition:background, color 0.2s ease 0s;
		}
		.productBlock:hover {
			background:rgba(80, 25, 10, 0.5);
			color:#efefef;
			border:1px solid white;
		}
		
		.productImage img {
			display:block;
			margin-left:auto;
			margin-right:auto;
			width:280px;
			height:280px;
			opacity:0.9;
			border:1px solid #cfcfcf;
			transition:border, opacity 0.2s ease 0s;
		}
		.productImage img:hover {
			display:block;
			opacity:1;
			border:1px solid #efefef;
		}
		.productName {
			text-align:center;
			margin-top:6px;
		}
		.productDesc {
			margin-left:10px;
			margin-right:10px;
			text-align:justify;
		}
		.productPrice {
			text-align: center;
			font-size:larger;
			color:#c2e3c3;
			text-shadow:1px 1px green;
		}
		.productPrice:hover {
			color:#d3f3d3;
			text-shadow:1px 1px lime;
		}
		.productStatus {
			text-align:center;
			font-weight:bolder;
			font-size:1.12em;
			color:#c2efc2;
		}
		.productInventory {
			text-align:center;
		}
		.updated {
			color:#989898;
			font-style:italic;
			text-align:center;
			font-size:0.98em;
		}

		.productLowInventory, .error {
			color:red;
		}
		footer {
			text-align:center;
			display:block;
			width:90%;
			margin-left:5%;
			margin-right:5%;
		}
	</style>
</head>
<body>
	<header>
		<h1>DMACC Electronics Store!</h1>
		<h2>Products for your Home and School Office</h2>
	</header>
	<main>
<?php
	$st = $db->prepare("SELECT * FROM `wdv341_products` ORDER BY `product_name` DESC");
	$st->execute();

	while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
?>
		<div class="productBlock" id="product<?php echo $row['product_id']; ?>">
			<div class="productImage">
				<img src="productImages/<?php echo $row['product_image']; ?>">
			</div>
			<h3 class="productName"><?php echo $row['product_name']; ?></h3>	
			<p class="productDesc"><?php echo $row['product_description']; ?></p>
			<p class="productPrice">$<?php echo $row['product_price']; ?></p>
			<?php
			if ($row['product_status']) {
				echo "<p class=\"productStatus\">{$row['product_status']}</p>";
			}

			$class = (($row['product_inStock'] < 10) ? "productLowInventory" : "");
			
			$nd = date("F j, Y", strtotime($row['product_update_date']));
			?>
			<p class="productInventory <?php echo $class; ?>"><?php echo $row['product_inStock']; ?> in Stock!</p>
			<p class="updated">[ Last updated <?php echo $nd; ?> ]</p>
		</div>
<?php
	}
	$db = null;
?>
	</main>
<?php
}
catch (PDOException $e) {
	echo("<b class=\"error\">Error: {$e->getMessage()}</b>");
}
?>
	<footer>
		<p><a href="/homework/wdv341/selectEvents" title="Previous assignment" alt="Previous assignment">Unit 7: Create selectEvents.php</a> &bull; <a href="/homework/wdv341/deliverEventObject" alt="Next assignment" title="Next assignment">Unit 9: Formatting JSON Output/AJAX</a></p>
		<p><a href="/homework/index?c=wdv341">&rarr; Return to WDV341 Homework &larr;</a> &bull; <a href="https://github.com/Babkock/homework/blob/master/wdv341/retailProducts.php" target="_blank" title="GitHub" alt="GitHub">View Source Code</a></p>
	</footer>
</body>
</html>