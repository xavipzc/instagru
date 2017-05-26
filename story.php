<?php

	session_start();

?>
<?php if (isset($_SESSION['user'])): require('themes/header.php'); ?>

	<h1>Your story</h1>
	<p>Hey <?php echo ucfirst($_SESSION['user']); ?> you can use your webcam to start telling your story or upload your own pictures.</p>

	<div class="cam align-left">
		<video id="video"></video>

		<div class="sticker-select">
			<label for="stickers-list">Change sticker</label><br>
			<select name="stickers-list" id="stickers-list">
				<option value="thug">Thug</option>
				<option value="thug2">Thug 2</option>
				<option value="moustache">Moustache</option>
				<option value="filter1">Filter 1</option>
			</select>
		</div>

		<img src="themes/img/stickers/thug.png" width="400px" height="300px" id="sticker">
		<button id="startbutton" class="btn btn-blue">Prendre une photo</button>
	</div>
	<div class="align-left">
		<canvas id="canvas"></canvas>
		<br><span id="message"></span>
	</div>

	<div class="clear"></div>

	<input id="file" type="file" multiple />
	

	<script src="themes/js/func.js"></script>
	<script src="themes/js/camagru.js"></script>

<?php require('themes/footer.html'); else: header('Location: 404.php'); ?>

<?php endif; ?>
