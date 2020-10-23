// JavaScript Document
/*
	Create JSON Object
	October 22, 2020
	JSON Team Project: Tanner, Raymond, Justin, Robby
*/
/*
	This file will:
	
	- Create a Javascript object containing an array of records with each record including an array
	- Convert the Javascript object into a JSON object
	- Store the JSON object into local storage
	
	This will be given to students to run as part of a web page that will consume the JSON object
	Goal: Provide an example of how to create a JSON object in JS
	Goal: Provide an example of how to consume a JSON object in JS

	Use the following data for this object:
	
		student_id = 332443
		student_gpa = 3.6
		student_courses = ["WDV101","WDV131","WDV105"]	

		student_id = 545467
		student_gpa = 2.7
		student_courses = ["WDV101","WDV131","WDV105","WDV221","WDV205"]	
		
		student_id = 128574
		student_gpa = 3.4
		student_courses = ["WDV101","WDV131","WDV105","WDV221","WDV205","WDV341"]	
	
		student_id = 750056
		student_gpa = 1.85
		student_courses = ["WDV101","WDV131","WDV105","WDV221","WDV205"]		
		
		
*/

let studentInfo = {
	records: [
		{
			student_id: 332443,
			student_gpa: 3.6,
			student_courses: ["WDV101", "WDV131", "WDV105"]
		},
		{
			student_id: 545467,
			student_gpa: 2.7,
			student_courses: ["WDV101", "WDV131", "WDV105", "WDV221", "WDV205"]
		},
		{
			student_id: 128574,
			student_gpa: 3.4,
			student_courses: ["WDV101", "WDV131", "WDV105", "WDV221", "WDV205", "WDV341"]
		},
		{
			student_id: 750056,
			student_gpa: 1.85,
			student_courses: ["WDV101", "WDV131", "WDV105", "WDV221", "WDV205"]
		}
	]
};

let students = JSON.stringify(studentInfo);

window.localStorage.setItem("studentInfo", students);
