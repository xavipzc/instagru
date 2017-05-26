<?php

	try {
		require('config/database.php');
		$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		if (!empty($_GET['username']) && !empty($_GET['token']))
		{
			$req = $conn->prepare("SELECT token FROM users WHERE username = ? AND active = '1'");
			$req->execute([$_GET['username']]);
			$user = $req->fetch();

			if ($user && ($_GET['token'] == $user['token']))
			{
				require_once('themes/header.php');
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
				require_once('themes/footer.html');
			}
			else
			{
				require_once('themes/header.php');
				?>

					<h1>Change your password</h1>
					<p>Something went wrong.</p>

				<?php
				require_once('themes/footer.html');
			}
		}
		else
		{
			header('Location: login.php');
		}
	}
	catch (PDOException $e) {
		echo $req . "<br>" . $e->getMessage();
	}

	$conn = null;

?>
