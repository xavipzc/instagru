<?php
	
	session_start();

	if ($_SESSION['user'])
	{

		?><?php require_once('themes/header.html'); ?>

		<div class="container">

			<h1><?php echo $_SESSION['user']; ?>'s Timeline</h1>
			<p>Hello <?php echo $_SESSION['user']; ?></p>

		</div>

		<?php require_once('themes/footer.html');

	}
	else
	{
		header("Location: index.php");
	}

?>