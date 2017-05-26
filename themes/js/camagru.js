(function() {

  var streaming    = false,
      video        = document.querySelector('#video'),
      s_list	     = document.querySelector('#stickers-list'),
      sticker      = document.querySelector('#sticker'),
      canvas       = document.querySelector('#canvas'),
      startbutton  = document.querySelector('#startbutton'),
      message      = document.querySelector('#message'),
      file         = document.querySelector('#file'),
      allowedTypes = ['png', 'jpg', 'jpeg', 'gif'],
      width        = 400,
      height       = 0;

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

    var tmp  = document.querySelector('#tmp');
 	  canvas.width = width;
    canvas.height = height;
    canvas.className = "rendu";
    if (tmp) { canvas.getContext('2d').drawImage(tmp, 0, 0, width, height); }
    else { canvas.getContext('2d').drawImage(video, 0, 0, width, height); }
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

function createThumbnail(file) {

        var reader = new FileReader();

        reader.addEventListener('load', function() {

            var base       = document.querySelector('.cam'),
                imgElement = document.createElement('img');
            imgElement.setAttribute('width', width);
            imgElement.setAttribute('height', height);
            imgElement.src = this.result;
            imgElement.id = 'tmp';
            imgElement.className = 'upload';
            base.appendChild(imgElement);

        });

        reader.readAsDataURL(file);
    }

  startbutton.addEventListener('click', function(ev){
     takepicture(readData);
     ev.preventDefault();
  }, false);

  file.addEventListener('change', function() {
    var files = this.files,
        filesLen = files.length,
        imgType;

        for (var i = 0; i < filesLen; i++) {

            imgType = files[i].name.split('.');
            imgType = imgType[imgType.length - 1];

            if (allowedTypes.indexOf(imgType) != -1) {
                createThumbnail(files[i]);
            }



        }
  });

})();
