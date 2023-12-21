function formatString(seconds) {
	// Calculate minutes and remaining seconds
	var minutes = Math.floor(seconds / 100);
	var remainingSeconds = seconds % 100;

	// Format the result as "mmm:ss"
	var formattedTime =
		minutes.toString().padStart(3, "0") +
		":" +
		remainingSeconds.toString().padStart(2, "0");

	return formattedTime;
}

class Timer {
	callbackStartTime;
	remaining = 0;
	paused = false;
	timerId = null;
	count = 0;
	_callback;
	_delay;

	constructor(callback, delay) {
		this._callback = callback;
		this._delay = delay;
	}

	pause() {
		if (!this.paused) {
			console.log("paused");

			this.clear();
			this.remaining = new Date().getTime() - this.callbackStartTime;
			this.paused = true;
		}
	}

	resume() {
		if (this.paused) {
			if (this.remaining) {
				setTimeout(() => {
					this.run();
					this.paused = false;
					this.start();
				}, this.remaining);
			} else {
				this.paused = false;
				this.start();
			}
		}
	}

	reset() {
		this.count = 0;
		this.clear();
		this.paused = true;
		this._callback(0);
	}

	clear() {
		clearInterval(this.timerId);
	}

	start() {
		if (this.paused) {
			this.resume();
			return;
		}

		this.timerId = setInterval(() => {
			this.run();
		}, this._delay);
	}

	run() {
		this.callbackStartTime = new Date().getTime();
		this._callback(++this.count);
	}
}
