// JavaScript Document
/*
	Unit 9: Mocha-Chai Test Automation
	October 27, 2020
	Tanner Babcock
*/

var validInput = function(inValue){
	inValue += "";	//turns all inValues into strings
	if(inValue.trim() == "" || inValue == 'null' || inValue == 'undefined'){
		return false;
	}
	return true;
}

module.exports = validInput;
