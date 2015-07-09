$(document).ready(function() {
	var $headerMenu = $("#header-menu"),
		$menuMobile = $headerMenu.siblings(".menu-mobile");

	$menuMobile.click(function() {
		if ($headerMenu.css("display") === "none") {
			$headerMenu.slideDown();
		} else {
			$headerMenu.slideUp();
		}
		$(this).toggleClass("icon-menu-open icon-menu-close");
	});

	// Prevent scrolling while menu is open
	$("body").on("mousewheel touchmove", function(e) {
		if ($menuMobile.hasClass("icon-menu-open")) {
			e.preventDefault();
			e.stopPropagation();
		}
		return;
	});
});

/*
function footerSubscription() {
	// When clicking on the error, hide it and focus on the field
	$("#footer-newsletter-error").click(function() {
		$(this).addClass("hidden");
		$("#footer-newsletter").focus();
	});

	// When the user presses on "enter"
	$("#footer-newsletter").keyup(function(e) {
		e = e || window.event;

		var key = e.keyCode || e.which,
			email = $("#footer-newsletter").val();

		if (parseInt(key) == 13) {
			// Validate email address
			if (!email.match(/^[a-zA-Z0-9.!#$%&"*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$/)) {
				$("#footer-newsletter-error").removeClass("hidden");
			} else {
				// Call API to add email
				$.ajax({
					url: wsUrl + "newsletter/subscribe/",
					method: "POST",
					dataType: "json",
					data: JSON.stringify({ "email": email })
				}).done(function(data) {
					modalBox.open({ content: data.msg });
				}).fail(function(msg) {
					//console.log(msg);
				});
			}
		}
	});
}

*/