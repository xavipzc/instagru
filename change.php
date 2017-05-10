<?php 
	
	require('config/database.php');

	try {
		$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Parse the url
		$user = $_GET['username'];
		$token = $_GET['token'];

		if ($user && $token)
		{
			// Get the token from the get user in the database
			$stmt = $conn->prepare("SELECT token FROM users WHERE username like :username");
			if ($stmt->execute(array(':username' => $user)) && $row = $stmt->fetch())
			{
				$tokendb = $row['token'];
			}

			if ($tokendb && ($token == $tokendb))
			{
				require_once('themes/header.html');
				require_once('themes/navbar.html');
				?>

				<div class="container">

					<h1>Change your password</h1>
					<form action="change_pwd.php" method="POST" class="align-center">

						<label for="passwd">New password</label>
						<br>
						<input type="password" name="passwd" id="passwd" placeholder="New password" required>
						<br>
						<input type="hidden" name="username" value="<?php echo $user; ?>" required>
						<input type="submit" name="submit" value="Change it" class="btn btn-blue">
						<br>

					</form>

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

					<h1>Change your password</h1>
					<p>Something went wrong.</p>

				</div>

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
		echo $sql . "<br>" . $e->getMessage();
	}

	$conn = null;

?>
