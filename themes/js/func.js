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

function my_likes_func($nb) {
	html = getXMLHttpRequest();

	html.onreadystatechange = function() {
		if (html.readyState == 4 && (html.status == 200 || html.status == 0)) {
			alert($nb + html.responseText);
		}
	};
	html.open("GET", "like.php?id="+$nb, true);
	html.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	html.send();
}