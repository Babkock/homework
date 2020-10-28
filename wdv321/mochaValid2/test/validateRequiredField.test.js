// JavaScript Document
/*
   Unit 10: Mocha-Chai Test Automation
   October 24, 2020
   Tanner Babcock
*/

var assert = require('chai').assert;
var validInput = require('../app/validateRequiredField');
var validatePhoneNumber = require('../app/validatePhoneNumber.js');
var validateZipCode = require('../app/validateZipCode.js');
var validateEmail = require('../app/validateEmail.js');
var validateReplace = require('../app/validateReplace.js');

describe("Testing Input Required", function(){
	
	it("The letter a should pass", function(){
		assert.isTrue(validInput('a'));		
	});
	
	it("The number 4 should pass", function() {
		assert.isTrue(validInput(4));
	});
	
	it("Empty or '' should fail", function() {
		assert.isFalse(validInput(' '));
	});	
	
	it("A single space should fail", function() {
		assert.isFalse(validInput(' '));
	});
	
	it("Two or more spaces should fail", function(){
		assert.isFalse(validInput('  '));
	});
	
	it("The word null should fail", function() {
		assert.isFalse(validInput('null'));
	});
	
	it("The word undefined should fail", function() {
		assert.isFalse(validInput('undefined'));
	});
	
	it("The value 'a 4' should pass", function(){
		assert.isTrue(validInput('a 4'));
	});
	
});	//end "Testing Input Required"

describe("Testing Valid Phone Number", function(){
	
	it("Input is required", function() {
		assert.isTrue(validatePhoneNumber(5553210220));
	});
	it("Input must be numeric", function() {
		assert.isFalse(validatePhoneNumber("astring"));
	});
	it("Input must be integers", function() {
		assert.isFalse(validatePhoneNumber(5.34));
	});
	it("Input must be 10 numbers", function() {
		assert.isTrue(validatePhoneNumber(5554442468));
		assert.isFalse(validatePhoneNumber(444321));
	});
	it("Input must not be a string", function() {
		assert.isFalse(validatePhoneNumber("5554442468"));
		assert.isTrue(validatePhoneNumber(5554442468));
	});
	it("Input must not be undefined", function() {
		assert.isFalse(validatePhoneNumber(undefined));
		assert.isFalse(validatePhoneNumber(null));
	});
});

describe("Testing Valid Email Addresses", function() {
	it("Input is required", function() {
		assert.isTrue(validateEmail("tababcock@dmacc.edu"));
		assert.isFalse(validateEmail("tababcock"));
	});
});
