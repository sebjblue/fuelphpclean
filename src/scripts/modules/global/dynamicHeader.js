var dynamicHeader = (function() {
    "use strict";
    var $header = $("#header"),
        $container = $("#container"),
        state = "max";

    function minifyHeader(e) {
		if (window.pageYOffset >= 1 && state === "max") {
            state = "min";
			$header.addClass("isMinified");
            $container.addClass("headerMinified");
        }else if (window.pageYOffset <= 1 && state === "min") {
            state = "max";
			$header.removeClass("isMinified");
			$container.removeClass("headerMinified");
        }
    }

    return {
        start: function() {
			minifyHeader();
            document.addEventListener("scroll", minifyHeader, true);
        },
        stop: function() {
            document.removeEventListener("scroll", minifyHeader, true);
        }
    };
}());
