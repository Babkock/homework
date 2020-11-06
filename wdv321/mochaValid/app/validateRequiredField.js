// JavaScript Document
/*
	Unit 8: Mocha-Chai Test Automation
	October 23, 2020
	Tanner Babcock
*/
/*
   Plan for testing phone numbers:
	- Determine if input is an integer type
	- Make sure input is 10 numbers. Between 1 billion and 9.9 billion
*/

var validInput = (inValue) => {
	inValue += "";	//turns all inValues into strings
	if (inValue.trim() == "" || inValue == 'null' || inValue == 'undefined') {
		return false;
	}
	return true;
}

module.exports = validInput;
