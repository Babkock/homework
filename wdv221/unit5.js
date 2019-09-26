function redPara() {
	document.getElementById("redpara").style.color = "#ff0000";
}

function yellowPara() {
	document.getElementById("yellowpara").style.backgroundColor = "#ffff00";
}

function toggleGreen() {
	if (document.getElementById("greenpara").style.backgroundColor == "#000")
		document.getElementById("greenpara").style.backgroundColor = "#009900";
	else if (document.getElementById("greenpara").style.backgroundColor == "#009900")
		document.getElementById("greenpara").style.backgroundColor = "#000";
}

function borderPara() {
	document.getElementById("borderpara").style.border = "2px solid white";
}

function removeBorder() {
	document.getElementById("borderpara").style.border = "none";
}

function changeTopic(val) {
	document.getElementById("topic").style.textAlign = val;
}

function changeFont(val) {
	document.getElementById("fontpara").style.fontFamily = val;
}

function bigSale() {
	document.getElementById("sale").style.fontSize = "24px";
}

function smallSale() {
	document.getElementById("sale").style.fontSize = "14px";
}

function bigFrog() {
	document.getElementById("frogImage").style.transform = "scale(2, 2)";
}

function smallFrog() {
	document.getElementById("frogImage").style.transform = "scale(1, 1)";
}

function toggleFrog() {
	if (document.getElementById("frogImage").style.display == "inline")
		document.getElementById("frogImage").style.display = "none";
	else if (document.getElementById("frogImage").style.display == "none")
		document.getElementById("frogImage").style.display = "inline";
}

document.getElementById("redpara").addEventListener("click", redPara);
document.getElementById("button").addEventListener("click", changeTopic("left"));
document.getElementById("fontpara").addEventListener("click", changeFont("Times"));
document.getElementById("button2").addEventListener("click", bigSale);
document.getElementById("button3").addEventListener("click", smallSale);
document.getElementById("yellowpara").addEventListener("click", yellowPara);
document.getElementById("button4").addEventListener("click", toggleFrog);
document.getElementById("borderpara").addEventListener("dblclick", borderPara);
document.getElementById("removeborder").addEventListener("click", removeBorder);

