function while04() {
	var x = 0;
	while (x < 5) {
		document.write("<p>" + x + "</p>");
	}
}

function for40() {
	for (var x = 4; x > -1; x--) {
		document.write("<p>" + x + "</p>");
	}
}

function print15() {
	for (var x = 1; x < 6; x++) {
		document.write("<p>" + x + "</p>");
	}
}

function loopTil40() {
	document.write("<p>");
	for (var x = 5; x <= 40; x += 5) {
		document.write("" + x + " ");
	}
	document.write("</p>");
}

function writeOptions() {
	for (var x = 1; x < 7; x++) {
		document.write("<option value=\"Option" + x + "\">Option " + x + "</option>");
	}
}

