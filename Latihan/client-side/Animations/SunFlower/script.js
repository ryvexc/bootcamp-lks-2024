const spriteAnimationData = [
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

class SunFlower extends Animator {}

window.onload = () => {
	const sunFlower = new SunFlower(60, "object", spriteAnimationData, [
		"SunFlower",
		"0.06",
	]);

	sunFlower.startAnimation();
};
