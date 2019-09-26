var longDays = [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ];
	var longMonths = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];

var customerName = "Please Sign In";

function enlargeImage(inImage)	{
	//alert("inside enlargeImage()" );
	document.getElementById(inImage).style.transform = "scale(2,2)";
}

function originalSizeImage(inImage)	{
	//alert("inside originalSizeImage()");	
	document.getElementById(inImage).style.transform = "scale(1,1)";					
}

function signin() {
	customerName = prompt("Please enter your name: ");
	document.getElementById("customer").innerHTML = customerName;
}

document.getElementById("signin").addEventListener("click", signin);
document.getElementById("picHtml").addEventListener("mouseOver", enlargeImage("picHtml"));
document.getElementById("picHtml").addEventListener("mouseOut", originalSizeImage("picHtml"));

var t = new Date();

var today = document.getElementById("today");
today.innerHTML = longDays[t.getDay()] + ", " + longMonths[t.getMonth()] + " " + t.getDate() + ", " + (t.getYear() + 1899);
document.getElementById("customer").innerHTML = customerName;

