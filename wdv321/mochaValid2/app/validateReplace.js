/*
	Unit 9: Validation with Regular Expressions
	October 27, 2020
	Tanner Babcock
*/
var validateReplace = function(rstr) {
	var str = rstr.replace('/', '-');
	str = str.replace('\'', '-');
	str = str.replace('<', '-');
	str = str.replace('>', '-');
	return str;
};

module.exports = validateReplace;