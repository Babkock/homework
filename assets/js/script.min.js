$(document).ready(function() {
	$("#wdv221-toggle").on("click", function() {
		$(".wdv221").show();
		$(".wdv205").hide();
		$(".wdv131").hide();
		$(".wdv101").hide();
	});
	$("#wdv205-toggle").on("click", function() {
		$(".wdv205").show();
		$(".wdv221").hide();
		$(".wdv131").hide();
		$(".wdv101").hide();
	});
	$("#wdv131-toggle").on("click", function() {
		$(".wdv131").show();
		$(".wdv221").hide();
		$(".wdv205").hide();
		$(".wdv101").hide();
	});
	$("#wdv101-toggle").on("click", function() {
		$(".wdv101").show();
		$(".wdv221").hide();
		$(".wdv205").hide();
		$(".wdv131").hide();
	});
});

