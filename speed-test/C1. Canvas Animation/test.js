window.onload = function () {
	var canvas = document.getElementById("myCanvas");
	var context = canvas.getContext("2d");
	var x = 0;
	var y = canvas.height / 2;
	var radius = 20;
	var speed = 4;

	canvas.style.backgroundColor = "green";

	function animate() {
		context.clearRect(0, 0, canvas.width, canvas.height);

		context.beginPath();
		context.arc(x, y, radius, 0, 2 * Math.PI, false);
		context.fillStyle = "white";
		context.fill();

		x += speed;

		if (x - radius > canvas.width) {
			x = 0 - radius;
		}

		requestAnimationFrame(animate);
	}

	animate();
};
