function newCookie(n, val, days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		var expires = "; expires=" + date.toGMTString();
	}
	else
		var expires = "";
	document.cookie = n + "=" + val + expires + "; path=/";
}

function readCookie(n) {
	var name = n + "=";
	var cook = document.cookie.split(';');
	for (i = 0; i < cook.length; i++) {
		var c = cook[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1, c.length);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return null;
}

function delCookie(n) {
	newCookie(n, "", -1);
}

var pushed = 0;

$(document).ready(function() {
	$("button.create").click(function() {
		if (pushed != 1) {
			newCookie("authentication", "ff7371c78b19c0a7297", 122);
			console.log("Authentication cookie created\n");
			$(".box").append("<center><p><a href=\"about.html\" style=\"color:green\">Continue to About Page</a></p></center>");
			pushed = 1;
		}
	});

	$("button.destroy").click(function() {
		delCookie("authentication");
		delCookie("analytics");
		delCookie("display");
		$(".box").append("<center><p><a href=\"home.html\" style=\"color:red\">Logging Out...</a></p></center>");
	});
});
