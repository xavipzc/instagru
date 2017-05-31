<?php

	if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['passwd']))
	{
		require_once('includes/bootstrap.php');
		$conn = App::getDatabase();
		$user = $conn->query("SELECT * FROM users WHERE (username = :username OR email = :username) AND active = '1'",
							 [':username' => $_POST['username']])->fetch();

		$passwd = hash(whirlpool, $_POST['passwd']);

		if ($user['password'] === $passwd)
		{
			session_start();
			$_SESSION['user'] = $user['username'];
			$_SESSION['user_id'] = $user['id'];
			header('Location: index.php');
			exit();
		}
		else
		{
			$msg = '<br><span class="error-msg">Wrong username or password.</span><br>';
		}
	}

?>

<?php require('themes/header.php'); ?>

<div class="log-in">
	<div class="encart">

		<h1 class="align-center">
			<i class="fa fa-instagram" aria-hidden="true"></i> Camagru
		</h1>

		<form action="" method="POST" class="align-center">

			<label for="username">Username or email</label>
			<br>
			<input type="text" name="username" id="username" placeholder="Your username or email" required>
			<br>

			<label for="passwd">Password</label>
			<br>
			<input type="password" name="passwd" id="passwd" placeholder="Your password" required>
			<br>

			<input type="submit" name="submit" value="Log in" class="btn btn-blue">
			<?php echo $msg; ?>

		</form>

		<p class="align-center forgot">
			<a href="reset.php">Forgot your password ?</a>
		</p>

		<div class="separator"></div>

		<p class="align-center">
			Don't have an account ? <a href="signup.php">Sign up</a>
		</p>

	</div>
</div>

<?php require('themes/footer.html'); ?>
