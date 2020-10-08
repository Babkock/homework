<?php
/*
	Unit 9: Formatting JSON Output
	Tanner Babcock
	October 7, 2020
*/

class ProductContainer {
	private $productName;
	private $productPrice;
	private $productPageCount;
	private $productISBN;

	public function __construct($name, $price, $pc, $isbn) {
		$this->productName = $name;
		$this->productPrice = $price;
		$this->productPageCount = $pc;
		$this->productISBN = $isbn;
	}

	public function getName() { return $this->productName; }
	public function setName($s) { $this->productName = $s; }
	public function getPrice() { return $this->productPrice; }
	public function setPrice($p) { $this->productPrice = $p; }
}

	$productObj = new ProductContainer();
	
	$productObj->productName = "Product 1";
	//$productObj->productPrice = "$1.99";
//
	$returnObj = json_encode($productObj);	//create the JSON object
//	
	echo $returnObj;							//send results back to calling program
