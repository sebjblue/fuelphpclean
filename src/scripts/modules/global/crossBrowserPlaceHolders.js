var CrossBrowserPlaceHolders = (function() {
	"use strict";

	function init() {
		if (!hasPlaceholderSupport()) {
			addPlaceHolderSupport();
		}
	}

	function hasPlaceholderSupport() {
		var input = document.createElement("input");
		return ("placeholder" in input);
	}

	function addPlaceHolderSupport(){
		var inputs = document.getElementsByTagName("input"),
			textareas = document.getElementsByTagName("textarea"),
			i,
			countInputs = inputs.length,
			countTextareas = textareas.length;

		// Inputs
			for (i = 0; i < countInputs; i++) {
				if (inputs[i].getAttribute("placeholder")) {
					if (inputs[i].value === "") {
						ct.addClass("placeholder", inputs[i]);

						inputs[i].value = inputs[i].getAttribute("placeholder");
					}

					inputs[i].addEventListener("focus", crossBrowserPlaceholdersOnFocus);
					inputs[i].addEventListener("blur", crossBrowserPlaceholdersOnBlur);
				}
			}

		// Textareas
			for (i = 0; i < countTextareas; i++) {
				if (textareas[i].getAttribute("placeholder")) {
					if (textareas[i].value === "") {
						ct.addClass("placeholder", textareas[i]);

						textareas[i].value = inputs[i].getAttribute("placeholder");
					}

					textareas[i].addEventListener("focus", crossBrowserPlaceholdersOnFocus);
					textareas[i].addEventListener("blur", crossBrowserPlaceholdersOnBlur);
				}
			}
	}

	function crossBrowserPlaceholdersOnFocus(a, b){
		/*jshint validthis:true*/
		if (this.value === this.getAttribute("placeholder")) {
			this.value = "";
			ct.removeClass("placeholder", this);
		}
	}

	function crossBrowserPlaceholdersOnBlur(){
		/*jshint validthis:true*/
		if (this.value === "") {
			this.value = this.getAttribute("placeholder");
			ct.addClass("placeholder", this);
		}
	}

	return {
		init: init
	};
}());
