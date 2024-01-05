let cols = [];
let pdipPosition;
let health = 5;
let currentHealth = 5;
let score = 0;
let lose = false;
let time = {
	second: 0,
	minutes: 0,
};

let timerInterval;

const healthDisplay = document.getElementById("health-display");
const timeDisplay = document.getElementById("time-display");

const generateNewPdip = () => {
	cols.forEach((col) => (col.style.backgroundImage = "none"));
	pdipPosition = Math.floor(Math.random() * cols.length + 1);
	cols[pdipPosition - 1].style.backgroundImage = "url('assets/pdip.png')";
};

const renderHealth = () => {
	while (healthDisplay.firstChild)
		healthDisplay.removeChild(healthDisplay.firstChild);

	for (let i = 0; i < currentHealth; i++) {
		const health = document.createElement("i");
		health.classList.add("fa-solid", "fa-heart", "text-red-600", "text-2xl");
		healthDisplay.appendChild(health);
	}

	for (let i = currentHealth; i < health; i++) {
		const health = document.createElement("i");
		health.classList.add("fa-regular", "fa-heart", "text-red-600", "text-2xl");
		healthDisplay.appendChild(health);
	}
};

const startTimer = () => {
	timerInterval = setInterval(() => {
		time.second++;
		if (time.second == 60) {
			time.minutes++;
			time.second = 0;
		}

		timeDisplay.innerHTML = `${
			time.minutes < 10 ? "0" + time.minutes : time.minutes
		}:${time.second < 10 ? "0" + time.second : time.second}`;
	}, 1000);
};

const restart = () => {
	lose = false;
	score = 0;
	currentHealth = 6;
	clearInterval(timerInterval);
	time = { minutes: 0, second: 0 };
	timeDisplay.innerHTML = "00:00";
	increaseScore(0);
	game();
};

const increaseScore = (_score) => {
	document.getElementById("score-display").innerHTML = _score;
};

const triggerMouseDown = (clickPosition) => {
	if (clickPosition == pdipPosition) {
		cols[pdipPosition - 1].style.backgroundImage = "url('assets/pdi.png')";

		let audio = new Audio(
			"https://interactive-examples.mdn.mozilla.net/media/cc0-audio/t-rex-roar.mp3",
		);
		audio.play();

		increaseScore(++score);
	} else {
		if (currentHealth == 0) {
			const leaderboards = JSON.parse(localStorage.getItem("leaderboards"));
			leaderboards.push({
				name: localStorage.getItem("name"),
				score,
				time: `${time.minutes < 10 ? "0" + time.minutes : time.minutes}:${
					time.second < 10 ? "0" + time.second : time.second
				}`,
			});
			localStorage.setItem("leaderboards", JSON.stringify(leaderboards));

			if (confirm(`Your Score : ${score}\nYou wanna restart?`)) {
				restart();
			} else {
				alert("Goodbye");
				lose = true;
				return;
			}
		}
		currentHealth--;
		renderHealth();
	}
};

const triggerMouseUp = (clickPosition) => {
	if (clickPosition == pdipPosition) {
		cols[pdipPosition - 1].style.backgroundImage = "none";
		generateNewPdip();
	}
};

function init() {
	document.body.background = localStorage.getItem("bgImage");
	document.getElementById("name-display").innerHTML =
		localStorage.getItem("name");

	for (let i = 1; i <= 9; i++) {
		const column = document.getElementById("col-" + i);
		column.style.backgroundPosition = "center";
		column.style.backgroundRepeat = "no-repeat";
		column.style.backgroundSize = "60%";

		if (!lose) {
			column.onmousedown = () => triggerMouseDown(i);
			column.onmouseup = () => triggerMouseUp(i);
		}

		cols.push(column);
	}
}

function game() {
	generateNewPdip();
	renderHealth();
	startTimer();
}

window.onload = () => {
	init();
	game();
};
