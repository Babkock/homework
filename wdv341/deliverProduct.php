<?php
/*
	Unit 9: Formatting JSON Output
	Tanner Babcock
	October 7, 2020
*/
	
	$productObj = new stdClass();
	
	$productObj->productName = "Product 1";
	//$productObj->productPrice = "$1.99";
//
	$returnObj = json_encode($productObj);	//create the JSON object
//	
	echo $returnObj;							//send results back to calling program
