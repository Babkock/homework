// JavaScript Document
/*
	Create JSON Object
	October 20, 2020
	JSON Team Project: Tanner, Raymond, Justin, Robby
*/
/*
	This file will:
	
	- Create a Javascript object including an array
	- Convert the Javascript object into a JSON object
	- Store the JSON object into local storage
	
	Goal: Provide an example of how to create a JSON object in Javascript
	Goal: Provide an example of how to consume a JSON object in Javascript

	Use the following data for your JSON object

		student_id = 332443
		student_gpa = 3.6
		student_courses = ["WDV101","WDV131","WDV105"]

*/

let student1 = {
	student_id: 332443,
	student_gpa: 3.6,
	student_courses: [
		"WDV101", "WDV131", "WDV105"
	]
};
let student2 = {
	student_id: 545467,
	student_gpa: 2.7,
	student_courses: [
		"WDV101", "WDV131", "WDV105", "WDV221", "WDV205"
	]
};
let student3 = {
	student_id: 128574,
	student_gpa: 3.4,
	student_courses: [
		"WDV101", "WDV131", "WDV105", "WDV221", "WDV205", "WDV341"
	]
};

let JSONstudent1 = JSON.stringify(student1);
let JSONstudent2 = JSON.stringify(student2);
let JSONstudent3 = JSON.stringify(student3);

let storage = window.localStorage;
storage.setItem("332443", JSONstudent1);
storage.setItem("545467", JSONstudent2);
storage.setItem("128574", JSONstudent3);

//console.log(JSONstudentInfo);
