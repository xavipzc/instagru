<?php

	session_start();

	if (isset($_POST['submit']))
	{
		$username = $_POST['username'];
		$passwd = hash(whirlpool, $_POST['passwd']);

		require('config/database.php');

		try {
			$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt = $conn->prepare("SELECT password,active FROM users WHERE username like :username");
			if ($stmt->execute(array(':username' => $username)) && $row = $stmt->fetch())
			{
				$passwddb = $row['password'];
				$active = $row['active'];
			}

			// Check if the account is already active
			if ($passwddb)
			{
				if($active == '0')
				{
					$msg = 'Your account isn\'t activate ! Check your inbox.';
				}
				else
				{
					// Comparaison, if it's true, creation of a user session
					if ($passwddb == $passwd)
					{
						$_SESSION['user'] = $username;
						header('Location: index.php');
					}
					else
					{
						$msg = "Wrong username or password.";
					}
				}
			}
			// Username doesn't match
			else
			{
				$msg = "Your username doesn't exist !";
			}
		}
		catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}

		$conn = null;
	}

?>

<?php require_once('themes/header.html'); ?>

<div class="container log-in">

	<div class="encart">
		<h1 class="align-center">
			<i class="fa fa-instagram" aria-hidden="true"></i> Camagru
		</h1>

		<form action="login.php" method="POST" class="align-center">

			<label for="username">Username</label>
			<br>
			<input type="text" name="username" id="username" placeholder="Your username" required>
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
	
</div>

<?php require_once('themes/footer.html'); ?>