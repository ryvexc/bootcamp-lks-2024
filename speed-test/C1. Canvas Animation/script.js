var circle;

const mapArea = {
	canvas: document.createElement("canvas"),

	init: function () {
		this.canvas.width = 400;
		this.canvas.height = 320;
		this.context = this.canvas.getContext("2d");
		this.canvas.style.backgroundColor = "green";
		document.body.insertBefore(this.canvas, document.body.childNodes[0]);
		this.interval = setInterval(updateGameArea, 100);
	},

	clear: function () {
		this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
	},
};

function Circle(width, height, color, x, y) {
	this.width = width;
	this.height = height;
	this.speedX = 0;
	this.speedY = 0;
	this.x = x;
	this.y = y;
	this.color = color;
	ctx = mapArea.context;

	this.update = function () {
		ctx.fillStyle = color;
		ctx.beginPath();
		ctx.arc(
			x,
			mapArea.canvas.height / 2,
			this.width + this.height / 2,
			0,
			2 * Math.PI,
		);
		ctx.closePath();
		ctx.fill();

		x += 10;

		if (x - this.width + this.height / 2 > 400) {
			x = 0 - this.width + this.height / 2;
		}

		requestAnimationFrame(this.update);
	};

	this.newPos = function () {
		this.x += this.speedX;
		this.y += this.speedY;
	};
}

function updateGameArea() {
	mapArea.clear();
	circle.newPos();
	circle.update();
}

const startCanvasAnimation = () => {
	mapArea.init();
	circle = new Circle(10, 10, "white", 0, 0);
	circle.speedX += 1;
};
