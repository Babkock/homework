// JavaScript Document
/*
   Unit 9: Validation with Regular Expressions
   October 29, 2020
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
	
});

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

/*
	Email Validation Test Plan:

	- Create a function that will return true if a string is a valid email address
	- The string must contain a '@' and then a '.' for the domain
	- The function should return false if '@' or '.' are absent
*/

describe("Testing Valid Email Addresses", function() {
	it("Input is required", function() {
		assert.isTrue(validateEmail("tababcock@dmacc.edu"));
	});
	it("Input must have all parts of an email", function() {
		assert.isFalse(validateEmail("tababcock@dmacc"));
	});
	it("Input must be a real email address", function() {
		assert.isFalse(validateEmail("dmacc.edu"));
		assert.isFalse(validateEmail("foo@bar"));
	});
});

/*
	Zip Code Verification Test Plan:

	- Create a function that will return true if given a 5-digit int, or a string of 5 numbers
	- If the int is too small, too big, or the string contains any more or less than 5 numbers,
	  return false
*/

describe("Testing Valid Zip Codes", function() {
	it("Input is required", function() {
		assert.isTrue(validateZipCode("50021"));
		assert.isTrue(validateZipCode(50021));
	});

	it("Input must be 5 digits", function() {
		assert.isTrue(validateZipCode("90059"));
		assert.isFalse(validateZipCode("900958"));
		assert.isFalse(validateZipCode("9004"));
		assert.isFalse(validateZipCode("9"));
	});

	it("Input must not have alphabetic letters", function() {
		assert.isFalse(validateZipCode("fdsfa115"));
	});
});

/*
	Special Character Replacer Test Plan:

	- Create a function that does not return a boolean true or false, but rather the input string
	  with special characters (', /, <, and >) replaced with dashes (-).
	- Function should return the given string with every instance of a special character replaced
	- There should be no special characters left
*/

describe("Testing replace function", function() {
	it("Input has been changed", function() {
		var str ="/// ''' <><";

		assert.isTrue(validateReplace(str) === "--- --- ---");
	});

	it("Input with words becomes sanitized", function() {
		var str2 = "hello// <''world''>";

		assert.isTrue(validateReplace(str2) === "hello-- ---world---");
	});
});
