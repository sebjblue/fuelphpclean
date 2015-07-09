function sanitizeTextInput(string) {
	var sanitizedString = string.replace(/(<([^>]+)>)/ig,""); // Strip tags

	sanitizedString = $.trim(sanitizedString); // Strip extra spaces and lines at the end and start
	sanitizedString = sanitizedString.replace(/\n\n+(?=\n)/g, "\n"); // Strip extra space in-text
	sanitizedString = sanitizedString.replace(/ +(?= )/g,""); // Strip extra line in-text

	return sanitizedString;
}

function sanitizeLinkInput(string) {
	var sanitizedString = string.replace(/(<([^>]+)>)/ig,""); // Strip tags

	sanitizedString = $.trim(sanitizedString); // Strip extra spaces and lines at the end and start
	sanitizedString = sanitizedString.replace(/\n/ig, ""); // Strip extra space in-text
	sanitizedString = sanitizedString.replace(/ +(?= )/g,""); // Strip extra line in-text

	return sanitizedString;
}
