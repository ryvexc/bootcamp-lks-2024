const canvas = document.getElementById("canvas");
const context = canvas.getContext("2d");

const clickers = [];
const projectiles = [];
const enemies = [];

let score = 0;
let time = {
	second: 0,
	minutes: 0,
};

class Virus {
	constructor(x, y, velocity, speed) {
		this.x = x;
		this.y = y;
		this.velocity = velocity;
		this.speed = speed;

		this.image = new Image();
		this.image.src = "images/coronavirus-gaedba68d4_1280.png";
	}

	draw() {
		context.drawImage(this.image, this.x, this.y, 80, 80);
	}

	update() {
		this.draw();
		this.x = this.x + this.velocity.x;
		this.y = this.y + this.velocity.y;
	}
}

class Projectile {
	constructor(x, y, radius, color, velocity) {
		this.x = x;
		this.y = y;
		this.radius = radius;
		this.color = color;
		this.velocity = velocity;
	}

	draw() {
		context.beginPath();
		context.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
		context.fillStyle = this.color;
		context.fill();
	}

	update() {
		this.draw();
		this.x = this.x + this.velocity.x;
		this.y = this.y + this.velocity.y;
	}
}

class Line {
	constructor(x, y, width) {
		this.x = x;
		this.y = y;
		this.width = width;
	}

	draw() {
		context.beginPath();
		context.strokeStyle = "blue";
		context.strokeRect(this.x, this.y, this.width, canvas.height - 130);
	}

	update() {
		this.draw();
		this.x = this.x + this.velocity.x;
		this.y = this.y + this.velocity.y;
	}
}

class ClickIndicator {
	constructor(x, width) {
		this.x = x;
		this.width = width;
		this.height = 130;
		this.color = "red";

		this.text = "a";
	}

	draw() {
		context.beginPath();
		context.strokeStyle = this.color;
		context.strokeRect(
			this.x,
			canvas.height - this.height,
			this.width,
			this.height,
		);

		context.font = "14px Arial";
		context.fillStyle = "red";
		context.fillText(
			this.text,
			this.x + this.width / 2,
			canvas.height - this.height / 2,
		);
	}

	clickAnimation() {
		context.beginPath();
		context.fillStyle = "red";
		context.fillRect(
			this.x,
			canvas.height - this.height,
			this.width,
			this.height,
		);

		setTimeout(() => {
			context.beginPath();
			context.fillStyle = "black";
			context.fillRect(
				this.x,
				canvas.height - this.height,
				this.width,
				this.height,
			);

			this.draw();
		}, 100);
	}

	update() {
		this.draw();
		this.x = this.x + this.velocity.x;
		this.y = this.y + this.velocity.y;
	}
}

function drawLine(width) {
	for (let i = 0; i < 4; i++) {
		new Line(i * width, 0, width).draw();
	}
}

function drawClickIndicator(width) {
	for (let i = 0; i < 4; i++) {
		const clicker = new ClickIndicator(i * width, width);
		clicker.text = ["D", "F", "J", "K"][i];
		clicker.draw();

		clickers[i] = clicker;
	}
}

function shoot(i) {
	const velocity = {
		x: 0,
		y: -15,
	};

	projectiles.push(
		new Projectile(
			60 + 120 * i,
			canvas.height - 130 - 5,
			10,
			"white",
			velocity,
		),
	);
}

function init() {
	canvas.width = innerWidth;
	canvas.height = innerHeight;

	context.fillStyle = "black";
	context.fillRect(0, 0, canvas.width, canvas.height);

	drawLine(120);
	drawClickIndicator(120);
}

function startTimer() {
	setInterval(() => {
		time.second++;
		if (time.second == 60) {
			time.minutes++;
			time.second = 0;
		}

		document.getElementById("time-display").innerHTML = `${
			time.minutes < 10 ? "0" + time.minutes : time.minutes
		}:${time.second < 10 ? "0" + time.second : time.second}`;
	}, 1000);
}

function animate() {
	requestAnimationFrame(animate);
	init();

	projectiles.forEach((projectile, index) => {
		projectile.update();

		// remove projectile if out from screen
		if (
			projectile.x + projectile.radius < 0 ||
			projectile.x - projectile.radius > canvas.width ||
			projectile.y + projectile.radius < 0 ||
			projectile.y - projectile.radius > canvas.height
		) {
			setTimeout(() => {
				projectiles.splice(index, 1);
			}, 0);
		}
	});

	enemies.forEach((enemy, index) => {
		enemy.update();

		projectiles.forEach((projectile, projectileIndex) => {
			const dist = Math.hypot(
				projectile.x - enemy.x - 40,
				projectile.y - enemy.y,
			);

			if (dist - 80 - projectile.radius < 1) {
				enemies.splice(index, 1);
				projectiles.splice(projectileIndex, 1);

				score++;
				document.getElementById("score-display").innerHTML = score;
			}
		});
	});
}

window.onload = () => {
	startTimer();
	animate();
};

window.onkeydown = (e) => {
	if (e.key == "d") {
		shoot(0);
		clickers[0].clickAnimation();
	} else if (e.key == "f") {
		shoot(1);
		clickers[1].clickAnimation();
	} else if (e.key == "j") {
		shoot(2);
		clickers[2].clickAnimation();
	} else if (e.key == "k") {
		shoot(3);
		clickers[3].clickAnimation();
	}
};

setInterval(() => {
	const virus = new Virus(
		25 + 120 * Math.floor(Math.random() * 4),
		-80,
		{ x: 0, y: 1 },
		1,
	);
	enemies.push(virus);
}, 3000);
