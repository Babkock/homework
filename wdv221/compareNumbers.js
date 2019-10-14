/*
 * Tanner Babcock
 * Intro Javascript
 * October 13, 2019
 * Unit 7
*/
function compareNumbers() {
	if (parseInt(document.getElementById("value1").value) == parseInt(document.getElementById("value2").value)) {
		document.getElementById("result").innerHTML = "Same";
	}
	else {
		document.getElementById("result").innerHTML = "Different";
	}
	return false;
}

function reset() {
	document.getElementById("value1").value = "";
	document.getElementById("value2").value = "";
	document.getElementById("result").innerHTML = "";
	return false;
}

document.querySelector("#compare").addEventListener("click", compareNumbers);
document.querySelector("#reset").addEventListener("click", reset);

