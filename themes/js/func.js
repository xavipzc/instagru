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

function my_likes_func(nb, elem, event) {

	var html 	= getXMLHttpRequest(),
		likes 	= elem.childNodes[2],
		heart 	= elem.childNodes[0];

	html.onreadystatechange = function() {
		if (html.readyState == 4 && (html.status == 200 || html.status == 0)) {

			var res = html.responseText.split(",");

			if (res[0] == 0)
			{
				likes.innerHTML = "";
				heart.classList.remove("blue");
			} else {
				if (res[1] == "0") {
					heart.classList.remove("blue");
				} else {
					heart.classList.add("blue");
				}
				likes.innerHTML = res[0];
			}
		}
	};
	html.open("GET", "like.php?id="+nb, true);
	html.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	html.send();
	event.preventDefault();
}
