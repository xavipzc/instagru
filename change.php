<?php

	if (!empty($_GET['username']) && !empty($_GET['token']))
	{
		require_once('includes/bootstrap.php');
		$conn = App::getDatabase();
		$user = $conn->query("SELECT token FROM users WHERE username = ? AND active = '1'",
							[$_GET['username']])->fetch();

		if ($user && ($_GET['token'] === $user['token']))
		{
			require('themes/header.php');
			?>

				<h1>Change your password</h1>
				<div class="encart">
				<form action="change_pwd.php" method="POST" class="align-center">

					<label for="passwd">New password</label>
					<br>
					<input type="password" name="passwd" id="passwd" placeholder="New password" required>
					<br>
					<label for="confirm">Confirm your password</label>
					<br>
					<input type="password" name="passwd_confirm" id="confirm" placeholder="Confirm password" required>
					<br>
					<input type="hidden" name="username" value="<?php echo htmlentities($_GET['username']); ?>" required>
					<input type="submit" name="submit" value="Change it" class="btn btn-blue">
					<br>

				</form>
				</div>

			<?php
			require('themes/footer.html');
		}
		else
		{
			require('themes/header.php');
			?>

				<h1>Change your password</h1>
				<p>Something went wrong.</p>

			<?php
			require('themes/footer.html');
		}
	}
	else
	{
		header('Location: 404.php');
	}

?>
