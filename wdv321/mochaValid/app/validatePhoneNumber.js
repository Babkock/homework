/*
	Unit 8: Mocha-Chai Test Automation
	October 23, 2020
	Tanner Babcock
*/
var validatePhoneNumber = function(phone) {
	if (phone !== parseInt(phone, 10)) { // Not a number
		return false;
	}
	if (phone < 1000000000) { // Too small
		return false;
	}
	else if (phone > 9999999999) { // Too big
		return false;
	}
	else {
		return true;
	}
};

module.exports = validatePhoneNumber;
