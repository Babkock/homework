$(document).ready(function() {
	$("#wdv341-toggle").on("click", function() {
		$(".wdv341").show();
		$(".wdv321").hide();
		$(".wdv221").hide();
		$(".wdv205").hide();
		$(".wdv131").hide();
		$(".wdv101").hide();
	});
	$("#wdv321-toggle").on("click", function() {
		$(".wdv341").hide();
		$(".wdv321").show();
		$(".wdv221").hide();
		$(".wdv205").hide();
		$(".wdv131").hide();
		$(".wdv101").hide();
	});
	$("#wdv221-toggle").on("click", function() {
		$(".wdv221").show();
		$(".wdv341").hide();
		$(".wdv321").hide();
		$(".wdv205").hide();
		$(".wdv131").hide();
		$(".wdv101").hide();
	});
	$("#wdv205-toggle").on("click", function() {
		$(".wdv205").show();
		$(".wdv341").hide();
		$(".wdv321").hide();
		$(".wdv221").hide();
		$(".wdv131").hide();
		$(".wdv101").hide();
	});
	$("#wdv131-toggle").on("click", function() {
		$(".wdv131").show();
		$(".wdv341").hide();
		$(".wdv321").hide();
		$(".wdv221").hide();
		$(".wdv205").hide();
		$(".wdv101").hide();
	});
	$("#wdv101-toggle").on("click", function() {
		$(".wdv101").show();
		$(".wdv341").hide();
		$(".wdv321").hide();
		$(".wdv221").hide();
		$(".wdv205").hide();
		$(".wdv131").hide();
	});
});

