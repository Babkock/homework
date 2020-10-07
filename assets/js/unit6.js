var pushed = 0;
var storage = window.localStorage;

$(document).ready(function() {
	$("button.create").click(function() {
		if (pushed != 1) {
			storage.setItem("authentication", "ff7371c78b19c0a7297");
			console.log("Authentication cookie created\n");
			$(".box").append("<center><p><a href=\"about.html\" style=\"color:green\">Continue to About Page</a></p></center>");
			pushed = 1;
		}
	});

	$("button.destroy").click(function() {
		storage.clear();
		$(".box").append("<center><p><a href=\"home.html\" style=\"color:red\">Logging Out...</a></p></center>");
	});
});
