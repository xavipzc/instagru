<?php 

	session_start();
	require('themes/header.php');

?>
<?php if (isset($_SESSION['user'])): ?>

		<h1><?php echo ucfirst($_SESSION['user']); ?>'s Timeline</h1>
		<p>Hello <?php echo ucfirst($_SESSION['user']); ?></p>

<?php else: ?>

		<h1>Normal Timeline</h1>
		<p>Hello you, you have to be connected to comment and like pictures. Sign up or Log you in.</p>

<?php endif; ?>

<?php require_once('themes/footer.html'); ?>