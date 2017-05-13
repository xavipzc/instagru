<?php 

	session_start();

?>
<?php if (isset($_SESSION['user'])): require('themes/header.php'); 

	if (!empty($_POST))
	{
		$msg = "OH";
	}
	else
	{
		$_POST["test"] = "1";
		print_r($_POST);
	}

?>

	<h1>Your story</h1>
	<p>Hey <?php echo ucfirst($_SESSION['user']); ?> you can use your webcam to start telling your story or upload your own pictures.</p>
	
	<?php echo $msg; ?>

	<div class="cam">
		<video id="video"></video>
		<button id="startbutton" class="btn btn-blue">Prendre une photo</button>
	</div>
	<canvas id="canvas"></canvas>
	<img src="http://placekitten.com/g/320/261" id="photo" alt="photo">

<?php require('themes/footer.html'); else: header('Location: login.php'); ?>

<?php endif; ?>