// JavaScript Document
/*
	Unit 9: Validation with Regular Expressions
	October 29, 2020
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
