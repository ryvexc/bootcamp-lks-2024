const wallnutSpriteData = [
	"00",
	"02",
	"03",
	"04",
	"05",
	"06",
	"07",
	"08",
	"09",
	"10",
	"11",
	"12",
	"12",
	"14",
	"15",
	"16",
	"17",
	"18",
	"19",
	"20",
	// "21",
	// "22",
	// "23",
	// "24",
];

const selected = [false, false, false, false];

const zombieSpriteData = {
	delay: 50,
	spriteObject: ["Zombie", "0.05"],
	spriteData: [
		"00",
		"01",
		"02",
		"03",
		"04",
		"05",
		"06",
		"07",
		"08",
		"09",
		"10",
		"11",
		"12",
		"13",
		"14",
		"15",
		"16",
		"17",
		"18",
		"19",
		"20",
		"21",
		"22",
		"23",
		"24",
		"25",
		"26",
		"27",
		"28",
		"29",
		"30",
		"31",
		"32",
		"33",
	],
};

const spriteDataForAnimator = [
	{
		cost: 175,
		delay: 120,
		spriteObject: ["IcePea", "0.12"],
		spriteData: [
			"02",
			"03",
			"04",
			"05",
			"06",
			"07",
			"08",
			"09",
			"10",
			"11",
			"12",
			"13",
			"14",
			"15",
			"16",
			"17",
			"18",
			"19",
			"20",
			"21",
			"22",
			"23",
			"24",
			"25",
			"26",
			"27",
			"28",
			"29",
			"30",
			"31",
		],
	},
	{
		cost: 100,
		delay: 120,
		spriteObject: ["PeaShooter", "0.12"],
		spriteData: [
			"00",
			"01",
			"02",
			"03",
			"04",
			"05",
			"06",
			"07",
			"08",
			"09",
			"10",
			"11",
			"12",
			"13",
			"14",
			"15",
			"16",
			"17",
			"18",
			"19",
			"20",
			"21",
			"22",
			"23",
			"24",
			"25",
			"26",
			"27",
			"28",
			"29",
			"30",
		],
	},
	{
		cost: 50,
		delay: 60,
		spriteObject: ["SunFlower", "0.06"],
		spriteData: [
			"00",
			"02",
			"03",
			"04",
			"05",
			"06",
			"07",
			"08",
			"09",
			"10",
			"11",
			"12",
			"12",
			"14",
			"15",
			"16",
			"17",
			"18",
			"19",
			"20",
		],
	},
	{
		cost: 50,
		delay: 120,
		spriteObject: ["Wallnut", "0.12"],
		spriteData: [
			"00",
			"01",
			"02",
			"03",
			"04",
			"05",
			"06",
			"07",
			"08",
			"09",
			"10",
			"11",
			"12",
			"13",
			"14",
			"15",
			"16",
			"17",
			"18",
			"19",
			"20",
			"21",
			"22",
			"23",
			"24",
			"25",
			"26",
			"27",
			"28",
			"29",
			"30",
			"31",
		],
	},
];
let selectedIndex = -1;
let coins = 50;

const shovel = document.getElementById("shovel");
const coinDisplay = document.getElementById("coin-display");

class Sun {
	constructor(left, top, random = true) {
		this.sunImgObject = document.createElement("img");
		this.sunImgObject.src = "../Sprites/General/Sun.png";
		this.sunImgObject.style.position = "absolute";
		this.sunImgObject.style.zIndex = 50;

		if (random) {
			this.sunImgObject.style.top = "0px";
			this.sunImgObject.style.left = `${Math.floor(
				Math.random() * (1001 - 350) + 350,
			)}px`;
		} else {
			this.sunImgObject.style.top = `${top}px`;
			this.sunImgObject.style.left = `${left}px`;
		}

		this.sunImgObject.style.width = "60px";
		this.sunImgObject.style.transitionDuration = "3s";
		this.sunImgObject.style.opacity = "0.925";

		this.sunImgObject.onclick = () => {
			coins += 25;
			updateCoins(coins);

			this.sunImgObject.remove();
		};

		this.startDisappearing();
	}

	drop() {
		this.sunImgObject.style.top = `${Math.floor(
			Math.random() * (525 - 150) + 150,
		)}px`;
	}

	startDisappearing() {
		this.sunTimeout = setTimeout(() => {
			this.sunImgObject.style.opacity = "0";
			setTimeout(() => {
				this.sunImgObject.remove();
			}, 3000);
		}, 4500);
	}

	clearSunTimeout() {
		clearTimeout(this.sunTimeout);
	}

	getObject() {
		return this.sunImgObject;
	}
}

const generateSun = (nodrop = false, random = true, left = 0, top = 0) => {
	const sun = new Sun(left, top, random);

	document.body.appendChild(sun.getObject());
	if (!nodrop) {
		setTimeout(() => {
			sun.drop();
		}, 100);
	}
};

window.onload = () => {
	document.body.style.userSelect = "none";
	updateCoins(coins);

	for (let i = 0; i < 2; i++) {
		generateSun();
	}

	const placeableGrid = document.getElementById("placeable-grid");

	setInterval(generateSun, 3000);

	shovel.onclick = () => {
		unSelectCard();
		localStorage.setItem("shovel_selected", true);
		shovel.style.opacity = "0.6";
	};

	while (placeableGrid.firstChild) {
		placeableGrid.removeChild(placeableGrid.firstChild);
	}
	const placeableGridWrapper = placeableGrid.getBoundingClientRect();

	const [x, y] = [8, 5];

	for (let i = 0; i < x * y; i++) {
		console.log("generating");
		const clickerComponent = document.createElement("div");
		clickerComponent.style.width = `${placeableGridWrapper.width / x}px`;
		clickerComponent.style.height = `${placeableGridWrapper.height / y}px`;

		clickerComponent.onmouseover = () => {
			clickerComponent.style.backgroundColor = "rgba(0, 0, 0, 0.2)";
		};

		clickerComponent.onmouseout = () => {
			clickerComponent.style.backgroundColor = "rgba(0, 0, 0, 0)";
		};

		clickerComponent.onclick = () => {
			if (clickerComponent.firstChild || selectedIndex == -1) return;

			const object = new Animator(
				spriteDataForAnimator[selectedIndex].delay,
				spriteDataForAnimator[selectedIndex].spriteData,
				spriteDataForAnimator[selectedIndex].spriteObject,
			);

			const presentableObject = object.getObject();
			presentableObject.onmouseover = () => {
				presentableObject.style.opacity = 0.8;
			};
			presentableObject.onmouseout = () => {
				presentableObject.style.opacity = 1;
			};
			presentableObject.onclick = () => {
				if (localStorage.getItem("shovel_selected") === "true") {
					clickerComponent.firstChild.remove();

					unSelectCard();
				}
			};

			if (localStorage.getItem("shovel_selected") === "false") {
				if (coins >= spriteDataForAnimator[selectedIndex].cost) {
					clickerComponent.appendChild(presentableObject);
					coins -= spriteDataForAnimator[selectedIndex].cost;

					if (
						spriteDataForAnimator[selectedIndex].spriteObject[0] == "SunFlower"
					) {
						console.log("sunflower planted");
						setInterval(() => {
							console.log("GENERATE FROM SUNFLOWER");
							const boundingClientRect =
								presentableObject.getBoundingClientRect();
							generateSun(
								true,
								false,
								boundingClientRect.left + Math.floor(Math.random() * 20),
								boundingClientRect.top + Math.floor(Math.random() * 10),
							);
						}, 10000);
					}

					updateCoins(coins);
					unSelectCard();
				}
			}
		};

		placeableGrid.appendChild(clickerComponent);
	}

	const zombie = new Animator(
		zombieSpriteData.delay,
		zombieSpriteData.spriteData,
		zombieSpriteData.spriteObject,
	);

	let defaultZombieStartLocation = 1050;

	const zombieObject = zombie.getObject();
	zombieObject.style.position = "absolute";
	zombieObject.style.width = "75px";
	zombieObject.style.top = "100px";
	zombieObject.style.left = `${defaultZombieStartLocation}px`;

	setInterval(() => {
		zombieObject.style.left = `${--defaultZombieStartLocation}px`;
	}, 50);

	setInterval(() => {
		console.log(zombieObject.getBoundingClientRect());
	}, 100);

	document.body.appendChild(zombieObject);
};

const unSelectCard = () => {
	shovel.style.opacity = "1";
	localStorage.setItem("shovel_selected", false);
	selectedIndex = -1;

	for (let i = 0; i < 4; i++) {
		selected[i] = false;
		document.getElementById(`card-${i + 1}`).style.border =
			"3px solid transparent";
	}
};

const selectCard = (index) => {
	unSelectCard();

	selectedIndex = index;

	document.getElementById(`card-${index + 1}`).style.border = selected[index]
		? "3px solid transparent"
		: "3px solid limegreen";
	selected[index] = !selected[index];
};

const updateCoins = (coin) => {
	coinDisplay.innerHTML = coin;
};
