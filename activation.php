<?php
	
	if (isset($_GET['username']) && isset($_GET['token']))
	{
		require_once('includes/bootstrap.php');

		$conn = App::getDatabase();
		$user = $conn->query('SELECT * FROM users WHERE username = ?', [$_GET['username']])->fetch();

		if ($user && ($user['token'] === $_GET['token']))
		{
			if ($user['active'] == 0){
				$msg = "Congrats ! Your account is activate !<br>";
				$msg .= 'You can now <a href="login.php">log into our fucking website</a>';
				$conn->query('UPDATE users SET active = 1, token = 0 WHERE username = ?', [$_GET['username']]);
			}
			else {
				$msg = 'Your account is already activate ! <a href="login.php">Log in.</a>';
			}
		}
		else
		{
			$msg = "Error ! Your account can't be activate.";
		}
	}
	else {
		header('Location: 404.php');
	}

?>

<?php
	require('themes/header.php');
?>

	<h1>Activation</h1>
	<?php echo $msg; ?>


<?php require('themes/footer.html'); ?>
