/**
 * Created by Sebastien on 2015-03-17.
 */
// global reference to modal element
var modalBox = (function() {
    "use strict";
    var modal = null,
        closeButton = null,
    //showCloseButton = true, // modal can be closed with closeButton
        blocking = false, // modal can only be closed with close() method
        modalWrapper = null,
        modalContent = null,
        beforeClose = null,
        isActive = false,
        afterClose = null,
    // left: 37, up: 38, right: 39, down: 40,
    // spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
         keys = [37, 38, 39, 40];

    function createModal () {
        closeButton = document.createElement("div");
        closeButton.className = "modal-close-button";

        modalContent = document.createElement("div");
        modalContent.className = "modal-content";

        modalWrapper = document.createElement("div");
        modalWrapper.className = "modal-wrapper";

        modal = document.createElement("div");
        modal.className = "modal hidden";

        // collate all elements
        modalWrapper.appendChild(closeButton);
        modalWrapper.appendChild(modalContent);
        modal.appendChild(modalWrapper);
        document.body.appendChild(modal);
    }

    function addContent(c) {
        var contentType = Object.prototype.toString.call(c);
        // inject content based on it"s type
        // block if no content exists
        if (!c) {
            throw new Error("modalBox needs content");
        }

        switch (contentType) {
            case "[object String]": {
                modalContent.innerHTML = c;
                break;
            }

            case "[object HTMLAnchorElement]": {
				$.ajax({
					url: c.getAttribute("href")
                }).done(function(html) {
					modalContent.innerHTML = html;
				});
				break;
            }

            default: {
                modalContent.appendChild(c);
                break;
            }
        }
    }

    function listener(e) {
        if (e.target === closeButton) {
            modalBox.close();
        }

        if (e.target === modal && !blocking) {
            close();
        }
    }

    /**
     * remove listeners
     * remove content
     * remove callbacks
     */
    function cleanUp() {
        modal.removeEventListener("click", listener, true);
        closeButton.className = "modal-close-button";
        modalContent.innerHTML = "";
        beforeClose = null;
        afterClose = null;
        blocking = false;
        isActive = false;
        modal.className = "modal hidden";
    }

    /**
     * open the modal box, with it"s intended title and content
     * c.content = HTML or string content to inject
     * c.showCloseButton = boolean, show the close button (x) or not
     * c.blocking = boolean, only close modal on a modalBox.close() command.
     * c.height = boolean, only close modal on a modalBox.close() command.
     */
    function open(c) {
        // make sure modal box has been created & cached
        // if not, create it
        if (isActive) {
            return;
        }

        if (modal === null) {
            createModal();
        }

        if (c.beforeClose) {
            beforeClose = c.beforeClose;
        }

        if (c.afterClose) {
            afterClose = c.afterClose;
        }

        if (c.blocking !== null) {
            blocking = c.blocking;
        }

        if (c.showCloseButton && !c.blocking) {
            closeButton.className = "modal-close-button";
        } else {
            closeButton.className = "modal-close-button hidden";
        }

        if (c.height) {
            modalWrapper.style.height = c.height;
        } else {
            modalWrapper.style.height = "auto";
        }

        addContent(c.content);
        isActive = true;
        modal.addEventListener("click", listener, true);

        modal.className = "modal active";
    }

    /**
     * close modal box (click x) and do nothing
     */
    function close() {
        // trigger immediate callback
        if (beforeClose !== null) {
            beforeClose();
        }

        cleanUp();
        // trigger final callback
        if (afterClose !== null) {
            afterClose();
            afterClose = null;
        }
    }

    // public API
    return {
        open: open,
        close: close
    };
}());
