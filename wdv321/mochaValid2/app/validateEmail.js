/*
	Unit 9: Mocha-Chai Test Automation
	October 27, 2020
	Tanner Babcock
*/
var validateEmail = function(em) {
	var reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

	return reg.test(String(em).toLowerCase());
};

module.exports = validateEmail;
