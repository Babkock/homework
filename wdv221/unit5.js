function redpara() {
	document.getElementById("redpara").style.color = "#ff0000";
}

function changeTopic(val) {
	document.getElementById("topic").style.textAlign = val;
}

function changeFont(val) {
	document.getElementById("fontpara").style.fontFamily = val;
}

function toggleSale() {
	if (document.getElementById("sale").style.fontSize == "24px")
		document.getElementById("sale").style.fontSize = "14px";
	if (document.getElementById("sale").style.fontSize == "14px")
		document.getElementById("sale").style.fontSize = "24px";
}

document.getElementById("redpara").addEventListener("click", redpara);
document.getElementById("button").addEventListener("click", changeTopic("left"));
document.getElementById("fontpara").addEventListener("click", changeFont("Times"));
document.getElementById("sale").addEventListener("click", toggleSale);

