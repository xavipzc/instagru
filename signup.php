<?php

	if (isset($_POST['submit']))
	{
		try {
			require('config/database.php');
			$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set the PDO error mode to exception

			$errors = array();

			if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){
				$errors['username'] = "Username not valid";
			}
			else {
				$req = $conn->prepare('SELECT id FROM users WHERE username = ?');
				$req->execute([$_POST['username']]);
				$user = $req->fetch();
				if ($user) {
					$errors['username'] = "This username is already taken";
				}
			}

			if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$errors['email'] = "Your email is not valid";
			}
			else {
				$req = $conn->prepare('SELECT id FROM users WHERE email = ?');
				$req->execute([$_POST['email']]);
				$email = $req->fetch();
				if ($email) {
					$errors['email'] = "This mail is already used";
				}
			}

			if (empty($_POST['passwd'])){
				$errors['passwd'] = "You have to define a password";
			}

			if (empty($errors))
			{
				date_default_timezone_set("Europe/Paris");
				$date = date('Y-m-d H:i:s');
				$passwd = hash(whirlpool, $_POST['passwd']);
				$token = hash(sha1, $date);

				$req = $conn->prepare("INSERT INTO users SET email = ?, username = ?, password = ?, token = ?, active = ?, created = ?");
				$req->execute([$_POST['email'], $_POST['username'], $passwd, $token, '0', $date]);

				// Préparation du mail contenant le lien d'activation
				$email = $_POST['email'];
				$subject = "Activate your account";
				$header = "From: noreply@camagru.io";

				// Le lien d'activation est composé du login(log) et de la clé(cle)
				$message = '			Welcome to Camagru,

				To activate your account, please follow the link bellow
				or copy/paste the link into your browser.

				http://localhost:8080/camagru/activation.php?username='.urlencode($_POST['username']).'&token='.urlencode($token).'

				---------------

				This is an automatic email.';

				mail($email, $subject, $message, $header) ; // Envoi du mail

				$msg = 'Thanks, a confirmation email has been sent to your inbox !';
			}

		}
		catch (PDOException $e) {
			echo $req . "<br>" . $e->getMessage();
		}

		$conn = null;
	}

?>

<?php require('themes/header.php'); ?>

<div class="log-in">
	<div class="encart">

		<h1 class="align-center">
			<i class="fa fa-instagram" aria-hidden="true"></i> Camagru
		</h1>
		<p class="align-center">
			Sign up to see photos from your friends.
		</p>

		<div class="separator"></div>

		<form action="" method="POST" class="align-center">

			<label for="email">Email</label>
			<br>
			<input type="text" name="email" id="email" placeholder="Your email" required>
			<br><?php if ($errors['email']) { echo '<span class="error-msg">' . $errors['email'] . '</span><br>'; }; ?>

			<label for="username">Username</label>
			<br>
			<input type="text" name="username" id="username" placeholder="Your username" required>
			<br><?php if ($errors['username']) { echo '<span class="error-msg">' . $errors['username'] . '</span><br>'; }; ?>

			<label for="passwd">Password</label>
			<br>
			<input type="password" name="passwd" id="passwd" placeholder="Choose a password" required>
			<br><?php if ($errors['passwd']) { echo '<span class="error-msg">' . $errors['passwd'] . '</span><br>'; }; ?>

			<input type="submit" name="submit" value="Sign Up" class="btn btn-blue">
			<br>

			<?php echo '<span class="success-msg">' . $msg . '</span><br>'; ?>
		</form>

		<div class="separator"></div>

		<p class="align-center">
			Have an account ? <a href="login.php">Log in</a>
		</p>

	</div>
</div>

<?php require_once('themes/footer.html'); ?>
