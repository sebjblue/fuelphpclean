/**
 *
 * @param c {target, query, callback}
 * @returns {{start: start, stop: stop, changeQuery: changeQuery}}
 * @constructor
 */

function InfiniteScroll(c) {
    "use strict";
    var target, query, callback, offset, beforeAjax;

    // make sure all required properties are in config object
    if (!c.query || !c.callback) {
        throw Error("InfiniteScroll requires the following properties:\ntarget (HTMl element)\nquery (URL string)\n callback (function)");
    } else {
        target = c.target || window;
        query = c.query;
        callback = c.callback;
		offset = c.offset || 200;
		beforeAjax = c.beforeAjax || null;
    }

    // make an AJAX call based on "query" value
    function callAPI(e) {
        if (criteriaReached()) {
            stop();

			if (beforeAjax !== null) {
				beforeAjax();
			}

			$.ajax({
				method: "GET",
                url: query,
                dataType: "text"
            }).done(function(data) {
				callback(data);
			}).fail(function(msg) {
				//console.log(msg);
			});
        }
    }

    // start listening for scroll events
    function start() {
        target.addEventListener("scroll", callAPI, true);
    }

    // stop listening for scroll events
    function stop() {
        target.removeEventListener("scroll", callAPI, true);
    }

    // determine if scrollbar is far enough to trigger query
    function criteriaReached() {
        var //viewport, // height of browser window
            fullHeight, // true height of the target's content
            scrolled, // amount of scrolling done
            result; // has criteria been met?

        if (target === window) {
            //viewport = target.innerHeight;
            fullHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            scrolled = target.scrollY;
        } else if (target !== window && target.nodeType === 1) {
            //viewport = target.clientHeight;
            fullHeight = target.scrollHeight;
            scrolled = target.scrollTop;
        }

        // has condition been met
        return fullHeight <= (scrolled + offset);
    }

    function changeQuery(q) {
        if (Object.prototype.toString.call(q) === "[object String]") {
            query = q;
        } else {
            throw new Error("tried to change query to a non-string format with:\n" + q);
        }
    }

    return {
        start: start,
        stop: stop,
        changeQuery: changeQuery
    };
}
