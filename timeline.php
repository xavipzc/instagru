<?php
	
	session_start();

	if ($_SESSION['user'])
	{

		require_once('themes/header.html');
		require_once('themes/navbar_logged.html');
?>

	<div class="container">

		<h1><?php echo ucfirst($_SESSION['user']); ?>'s Timeline</h1>
		<p>Hello <?php echo ucfirst($_SESSION['user']); ?></p>

	</div>

<?php 
	
	require_once('themes/footer.html');
	}
	else
	{
		require_once('themes/header.html');
		require_once('themes/navbar.html');
?>

	<div class="container">

		<h1>Normal Timeline</h1>
		<p>Hello you, you have to be connected to comment and like pictures. Sign up or Log you in.</p>

	</div>

<?php

	}

	require_once('themes/footer.html');

?>