function compareNames() {
	if (document.getElementsById("value1")[0].value == document.getElementsById("value2")[0].value) {
		document.getElementsById("result")[0].innerHTML = "Same";
	}
	else {
		document.getElementsById("result")[0].innerHTML = "Different";
	}
}

function reset() {
	document.getElementsById("value1")[0].value = "";
	document.getElementsById("value2")[0].value = "";
	document.getElementsById("result")[0].innerHTML = "";
}
