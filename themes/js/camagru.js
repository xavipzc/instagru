(function() {

  var streaming = false,
      video        = document.querySelector('#video'),
      s_list	   = document.querySelector('#stickers-list'),
      sticker      = document.querySelector('#sticker'),
      canvas       = document.querySelector('#canvas'),
      startbutton  = document.querySelector('#startbutton'),
      message  = document.querySelector('#message'),
      width = 400,
      height = 0;

  navigator.getMedia = ( navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia);

  navigator.getMedia(
    {
      video: true,
      audio: false
    },
    function(stream) {
      if (navigator.mozGetUserMedia) {
        video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL || window.webkitURL;
        video.src = vendorURL.createObjectURL(stream);
      }
      video.play();
    },
    function(err) {
      console.log("An error occured! " + err);
    }
  );

  video.addEventListener('canplay', function(ev){
    if (!streaming) {
      height = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', 0);
      canvas.setAttribute('height', 0);
      streaming = true;
    }
  }, false);

  s_list.addEventListener("change", function() {
	sticker.setAttribute('src', 'themes/img/stickers/'+ s_list.value +'.png');
  });

 function takepicture(callback) {

 	canvas.width = width;
    canvas.height = height;
    canvas.className = "rendu";
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    canvas.getContext('2d').drawImage(sticker, 0, 0, width, height);
    var img = canvas.toDataURL('image/png');

 	var html = getXMLHttpRequest();
 	html.onreadystatechange = function() {
		if (html.readyState == 4 && (html.status == 200 || html.status == 0)) {
			callback(html.responseText);
		}
	};
 	html.open("POST", "webcam.php", true);
	html.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	html.send("image=" + encodeURIComponent(img));
 }

 function readData(sData) {
	message.innerHTML = sData;
}

  startbutton.addEventListener('click', function(ev){
     takepicture(readData);
     ev.preventDefault();
  }, false);

})();
