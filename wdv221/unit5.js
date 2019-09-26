function redpara() {
	document.getElementById("redpara").style.color = "red";
}

function changeTopic(val) {
	document.getElementById("topic").style.textAlign = val;
}

function changeFont(val) {
	document.getElementById("fontpara").style.fontFamily = val;
}

document.getElementById("redpara").addEventListener("click", redpara);
document.getElementById("button").addEventListener("click", changeTopic("left"));
document.getElementById("fontpara").addEventListener("click", changeFont("Times New Roman"));

