/*
 * Tanner Babcock
 * October 13, 2019
 * Unit 7
*/
function compareNames() {
	var str = document.getElementById("value1").value;
	var str2 = document.getElementById("value2").value;
	if (str.toUpperCase() == str2.toUpperCase()) {
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

document.querySelector("#compare").addEventListener("click", compareNames);
document.querySelector("#reset").addEventListener("click", reset);

