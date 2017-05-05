<?php

	if (isset($_POST['submit']))
	{
		$email = $_POST['email'];
		$username = $_POST['username'];
		$passwd = hash(whirlpool, $_POST['passwd']);

		require('config/database.php');

		try {
			$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);

			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			date_default_timezone_set("Europe/Paris");
			$date = date('Y-m-d h:i:s');
			$token = hash(sha1, $date);
			$sql = "INSERT INTO users (email, username, password, token, active, created)
			VALUES ('$email', '$username', '$passwd', '$token', '0', '$date')";
	
			// use exec() because no results are returned
			$conn->exec($sql);

			// Préparation du mail contenant le lien d'activation
			$sujet = "Activate your account";
			$entete = "From: noreply@camagru.io";
			 
			// Le lien d'activation est composé du login(log) et de la clé(cle)
			$message = '			Welcome to Camagru,
			 
			To activate your account, please follow the link bellow
			or copy/paste the link into your browser.
			 
			http://localhost:8080/camagru/activation.php?username='.urlencode($username).'&token='.urlencode($token).'
			 
			---------------

			This is an automatic email.';

			mail($email, $sujet, $message, $entete) ; // Envoi du mail

			$msg = 'Thanks, a confirmation email has been sent to your inbox !';
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
		<p class="align-center">
			Sign up to see photos from your friends.
		</p>

		<div class="separator"></div>

		<form action="signup.php" method="POST" class="align-center">

			<label for="email">Email</label>
			<br>
			<input type="text" name="email" id="email" placeholder="Your email" required>
			<br>

			<label for="username">Username</label>
			<br>
			<input type="text" name="username" id="username" placeholder="Your username" required>
			<br>

			<label for="passwd">Password</label>
			<br>
			<input type="password" name="passwd" id="passwd" placeholder="Choose a password" required>
			<br>

			<input type="submit" name="submit" value="Sign Up" class="btn btn-blue">
			<br>
			<?php echo $msg; ?>

		</form>

		<div class="separator"></div>

		<p class="align-center">
			Have an account ? <a href="login.php">Log in</a>
		</p>

	</div>
</div>

</div>

<?php require_once('themes/footer.html'); ?>
