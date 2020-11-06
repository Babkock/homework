// JavaScript Document
/*
   Unit 8: Mocha-Chai Test Automation
   October 24, 2020
   Tanner Babcock
*/
var assert = require('chai').assert;
var validInput = require('../app/validateRequiredField');
var validatePhoneNumber = require('../app/validatePhoneNumber.js');

describe("Testing Input Required", () =>{
	it("The letter a should pass", () =>{
		assert.isTrue(validInput('a'));		
	});
	it("The number 4 should pass", () => {
		assert.isTrue(validInput(4));
	});
	it("Empty or '' should fail", () => {
		assert.isFalse(validInput(' '));
	});
	it("A single space should fail", () => {
		assert.isFalse(validInput(' '));
	});
	it("Two or more spaces should fail", () =>{
		assert.isFalse(validInput('  '));
	});
	it("The word null should fail", () => {
		assert.isFalse(validInput('null'));
	});
	it("The word undefined should fail", () => {
		assert.isFalse(validInput('undefined'));
	});
	it("The value 'a 4' should pass", () => {
		assert.isTrue(validInput('a 4'));
	});
});

describe("Testing Valid Phone Number", () => {
	it("Input is required", () => {
		assert.isTrue(validatePhoneNumber(5553210220));
	});
	it("Input must be numeric", () => {
		assert.isFalse(validatePhoneNumber("astring"));
	});
	it("Input must be integers", () => {
		assert.isFalse(validatePhoneNumber(5.34));
	});
	it("Input must be 10 numbers", () => {
		assert.isTrue(validatePhoneNumber(5554442468));
		assert.isFalse(validatePhoneNumber(444321));
	});
	it("Input must not be a string", () => {
		assert.isFalse(validatePhoneNumber("5554442468"));
		assert.isTrue(validatePhoneNumber(5554442468));
	});
	it("Input must not be undefined", () => {
		assert.isFalse(validatePhoneNumber(undefined));
		assert.isFalse(validatePhoneNumber(null));
	});
});