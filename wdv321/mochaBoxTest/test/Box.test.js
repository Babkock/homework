// JavaScript Document

var assert = require('chai').assert;
var Box = require('../app/Box');

describe("Testing Box", function(){
	
	it("should assert volume of the box", function(){
		var obj = new Box(10, 20, 30);
		assert.equal(obj.getVolume(), 6000);		
	});
	
	it("should assert volume of the box - Zero", function(){
		var obj = new Box(0, 20, 30);
		assert.equal(obj.getVolume(), 6000);		
	});	
	
});	//end "Testing Box"