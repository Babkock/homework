/*
	Unit 9: Validation with Regular Expressions
	October 29, 2020
	Tanner Babcock
*/
var validateReplace = function(rstr) {
	var reg = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;

	var str = rstr.replace(reg, '-');
	return str;
};

module.exports = validateReplace;