/**
 * Created by Sebastien on 2015-02-19.
 */

// adding ECMA5 polyfillable methods to javascript objects
// add "forEach" method to Array prototype
// IE <8
if (!Array.prototype.forEach) {
    Array.prototype.forEach = function(fun /*, thisArg */) {
        var t = Object(this),
            len = t.length >>> 0,
            thisArg = arguments.length >= 2 ? arguments[1] : void 0,
            i;

        if (this === void 0 || this === null) {
            throw new TypeError();
        }

        if (typeof fun !== "function") {
            throw new TypeError();
        }

        for (i = 0; i < len; i++) {
            if (i in t) {
                fun.call(thisArg, t[i], i, t);
            }
        }
    };
}

// add "every" method to Array prototype
// IE <8
if (!Array.prototype.every) {
    Array.prototype.every = function(fun ) {
        var t = Object(this),
        len = t.length >>> 0,
        thisArg = arguments.length >= 2 ? arguments[1] : void 0,
        i;

        if (this === void 0 || this === null) {
            throw new TypeError();
        }

        if (typeof fun !== "function") {
            throw new TypeError();
        }

        for (i = 0; i < len; i++) {
            if (i in t && !fun.call(thisArg, t[i], i, t)) {
                return false;
            }
        }

        return true;
    };
}

// add "filter" method to array prototype
// IE <8
if (!Array.prototype.filter) {
    Array.prototype.filter = function(fun /*, thisArg */) {
        var t = Object(this),
            len = t.length >>> 0,
            res = [],
            thisArg = arguments.length >= 2 ? arguments[1] : void 0,
            i,
            val;

        if (this === void 0 || this === null) {
            throw new TypeError();
        }

        if (typeof fun !== "function") {
            throw new TypeError();
        }

        for (i = 0; i < len; i++) {
            if (i in t) {
                val = t[i];

                // NOTE: Technically this should Object.defineProperty at
                //       the next index, as push can be affected by
                //       properties on Object.prototype and Array.prototype.
                //       But that method"s new, and collisions should be
                //       rare, so use the more-compatible alternative.
                if (fun.call(thisArg, val, i, t)) {
                    res.push(val);
                }
            }
        }

        return res;
    };
}

// add "some" method to Array prototype
// IE <8
if (!Array.prototype.some) {
    Array.prototype.some = function(fun /*, thisArg */) {
        var t = Object(this),
            len = t.length >>> 0,
            thisArg = arguments.length >= 2 ? arguments[1] : void 0,
            i;

        if (this === void 0 || this === null) {
            throw new TypeError();
        }

        if (typeof fun !== "function") {
            throw new TypeError();
        }

        for (i = 0; i < len; i++)        {
            if (i in t && fun.call(thisArg, t[i], i, t)) {
                return true;
            }
        }

        return false;
    };
}

// add "includes" method to String.prototype
// IE <11
if (!String.prototype.includes) {
    String.prototype.includes = function() {
        return String.prototype.indexOf.apply(this, arguments) !== -1;
    };
}
