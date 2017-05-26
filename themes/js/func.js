function getXMLHttpRequest() {
	var html = null;

	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				html = new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e) {
				html = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} else {
			html = new XMLHttpRequest();
		}
	} else {
		alert("Your browser doesn't support the XMLHTTPRequest object...");
		return null;
	}

	return html;
}
