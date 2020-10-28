/*
	Unit 9: Validation with Regular Expressions
	October 27, 2020
	Tanner Babcock
*/
var validateZipCode = function(zip) {
	var reg = /(^\d{5}$)|(^\d{5}-\d{4}$)/;

	return reg.test(String(zip));
};

module.exports = validateZipCode;
