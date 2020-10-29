/*
	Unit 9: Validation with Regular Expressions
	October 29, 2020
	Tanner Babcock
*/

var validateEmail = function(em) {
	var reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

	return reg.test(String(em).toLowerCase());
};

module.exports = validateEmail;
