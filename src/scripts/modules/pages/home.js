$(document).ready(function() {
	$(".city-box").click(function() {
		userSession.setLocation({ latitude: $(this).data("latitude"),
			longitude: $(this).data("longitude"),
			googlePlaceId: $(this).data("google-place-id"),
			locality: $(this).data("locality"),
			country: $(this).data("country"),
			url: baseUrl + "find-yoga-studios/"
		});
	});
});
