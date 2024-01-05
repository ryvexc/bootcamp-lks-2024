class Animator {
	constructor(delay, animationDataSprites, spriteObject) {
		this.delay = delay;
		this.animationDataSprites = animationDataSprites;
		this.spriteObject = spriteObject;
		this.animationStep = 0;

		this.object = document.createElement("img");
		this.object.style.width = "100%";

		this.startAnimation();
	}

	getSpriteIdentifierLocation(animationFrame) {
		return `../../Sprites/${this.spriteObject[0]}/frame_${animationFrame}_delay-${this.spriteObject[1]}s.gif`;
	}

	startAnimation() {
		this.animation = setInterval(() => {
			this.object.src = this.getSpriteIdentifierLocation(
				this.animationDataSprites[this.animationStep],
			);

			if (this.animationStep == this.animationDataSprites.length - 1)
				this.animationStep = 0;
			else this.animationStep++;
		}, this.delay);
	}

	stopAnimation() {
		clearInterval(this.animation);
		this.animationStep = 0;
	}

	getObject() {
		return this.object;
	}
}
