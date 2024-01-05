setTimeout(() => {
	document.getElementById("loader-screen").style.opacity = "0";
	console.log("HTML");

	setTimeout(() => {
		document.getElementById("loader-screen").style.display = "none";
	}, 500);
}, 3000);
