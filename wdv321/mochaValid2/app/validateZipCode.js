/*
	Unit 9: Mocha-Chai Test Automation
	October 27, 2020
	Tanner Babcock
*/
var validateZipCode = function(zip) {
	var reg = /(^\d{5}$)|(^\d{5}-\d{4}$)/;

	return reg.test(String(zip));
};

module.exports = validateZipCode;
