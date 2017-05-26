<?php

	if (isset($_POST['submit']))
	{
		if (empty($_POST['email'])) {
			$msg = '<br><span class="error-msg">Empty field!</span><br>';
		}
		else {
			try {
				require('config/database.php');
				$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$req = $conn->prepare("SELECT * FROM users WHERE email = ? AND active = '1'");
				$req->execute([$_POST['email']]);
				$user = $req->fetch();

				if ($user)
				{
					$token = hash(sha1, $date);
					$upd = $conn->prepare("UPDATE users SET token = ? WHERE email = ?");
					$upd->execute([$token, $user['email']]);

					// Préparation du mail contenant le lien d'activation
					$email = $user['email'];
					$subject = "Reset your password";
					$header = "From: noreply@camagru.io";

					// Le lien d'activation est composé du login(log) et de la clé(cle)
					$message = '			Hello,

					You forgot your password, if you want to change it please
					follow the link bellow or copy/paste the link into your browser.

					http://localhost:8080/camagru/change.php?username='.urlencode($user['username']).'&token='.urlencode($token).'

					---------------

					This is an automatic email.';

					mail($email, $subject, $message, $header) ; // Envoi du mail

					$msg = '<br><span class="success-msg">An email with the instructions has been sent to your inbox !</span><br>';
				}
				else { $msg = '<br><span class="error-msg">This account doesn\'t exist</span><br>'; }
			}
			catch (PDOException $e) {
				echo $req . "<br>" . $e->getMessage();
			}
			$conn = null;
		}
	}

?>
<?php require_once('themes/header.php'); ?>

<div class="log-in">
	<div class="encart">

		<h1 class="align-center">
			<i class="fa fa-instagram" aria-hidden="true"></i> Camagru
		</h1>

		<form action="" method="POST" class="align-center">

			<p class="align-center">
				Enter your email to reset your password.
			</p>

			<input type="email" name="email" id="email" placeholder="Your email" >
			<br>

			<input type="submit" name="submit" value="Reset password" class="btn btn-blue">
			<?php echo $msg; ?>

		</form>

		<p class="align-center forgot">
			<a href="login.php">Log in if you know it.</a>
		</p>

	</div>
</div>

<?php require_once('themes/footer.html'); ?>
