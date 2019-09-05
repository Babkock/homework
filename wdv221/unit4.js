let longDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
let longMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

let schoolName = "Des Moines Area Community College";
let name1 = "Mary";
let name2 = "Smith";
let totalSales = 3435.6;

function processString(inValue = "") {
	console.log("Number of characters: " + schoolName.length);
	console.log(schoolName.toUpperCase());
	console.log(schoolName.substring(0, 5));
}

function printName(firstName = "Bob", lastName = "Bobbs") {
	document.write("<p>" + firstName + " " + lastName + "</p>");
	document.write("<p>" + lastName + ", " + firstName + "</p>");
	document.write("<p>" + lastName.toUpperCase() + ", " + firstName + "</p>");
}

