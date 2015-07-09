var exportImage = {
	canvas: document.createElement("canvas"),
	options: {
		type: "image/jpeg",
		quality: "0.9"
	},
	convert: function(image) {
		var self = this,
			canvasContext = self.canvas.getContext("2d");

		// This allow the image to be loaded in the memory without any css constraint,
		// thus keeping it original size
		self.canvas.setAttribute("width", image[0].naturalWidth);
		self.canvas.setAttribute("height", image[0].naturalHeight);
		canvasContext.drawImage(image[0], 0, 0);

		return self.canvas.toDataURL(self.options.type, self.options.quality);
	}
};
