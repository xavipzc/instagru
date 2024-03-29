<?php

	session_start();

	if (isset($_POST['submit']))
	{
		require_once('includes/bootstrap.php');
		$conn = App::getDatabase();

		$errors = array();

		if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username']) || strlen($_POST['username']) > 30){
			if (strlen($_POST['username']) > 30) {
				$errors['username'] = "30 characters maximum !";
			} else {
				$errors['username'] = "Username not valid";
			}
		}
		else {
			$user = $conn->query('SELECT id FROM users WHERE username = ?', [$_POST['username']])->fetch();
			if ($user) {
				$errors['username'] = "This username is already taken";
			}
		}

		if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || strlen($_POST['email']) > 50){
			$errors['email'] = "Your email is not valid";
		}
		else {
			$email = $conn->query('SELECT id FROM users WHERE email = ?', [$_POST['email']])->fetch();
			if ($email) {
				$errors['email'] = "This mail is already used";
			}
		}

		if (empty($_POST['passwd']) || strlen($_POST['passwd']) < 4 || strlen($_POST['passwd']) > 128){
			if (strlen($_POST['passwd']) > 128) {
				$errors['passwd'] = "128 characters maximum !";
			}
			elseif (strlen($_POST['passwd']) < 4) {
				$errors['passwd'] = "More than 4 characters please !";
			} else {
				$errors['passwd'] = "You have to define a password";
			}
		}

		if (empty($errors))
		{
			$passwd = hash(whirlpool, $_POST['passwd']);
			$token = hash(sha1, getMyDateFormat());

			$conn->query("INSERT INTO users SET email = ?, username = ?, password = ?, token = ?, active = ?, created = ?",
						[$_POST['email'], $_POST['username'], $passwd, $token, '0', getMyDateFormat()]);

			// Préparation du mail contenant le lien d'activation
			$email = $_POST['email'];
			$subject = "Activate your account";
			$header = "From: noreply@camagru.io";
			$path_tab = explode("/", $_SERVER['PHP_SELF']);
			array_pop($path_tab);
			$path = implode("/", $path_tab);

			// Le lien d'activation est composé du login(log) et de la clé(cle)
			$message = '			Welcome to Camagru,

			To activate your account, please follow the link bellow
			or copy/paste the link into your browser.

			http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].''.$path.'/activation.php?username='.urlencode($_POST['username']).'&token='.urlencode($token).'

			---------------

			This is an automatic email.';

			mail($email, $subject, $message, $header) ; // Envoi du mail

			$msg = 'Thanks, a confirmation email has been sent to your inbox !';
		}
	}

	require('themes/header.php');
?>

<?php if (isset($_SESSION['user'])): ?>

	<div class="log-in">
		<div class="encart">
			<h1 class="align-center">
				<i class="fa fa-instagram" aria-hidden="true"></i> Camagru
			</h1>
			<p class="align-center">
				You are already log in. Please log out to sign up an account.
			</p>
		</div>
	</div>

<?php else: ?>

	<div class="log-in">
		<div class="encart">

			<h1 class="align-center">
				<i class="fa fa-instagram" aria-hidden="true"></i> Camagru
			</h1>
			<p class="align-center">
				Sign up to share photos with your friends.
			</p>

			<div class="separator"></div>

			<form action="" method="POST" class="align-center">

				<label for="email">Email</label>
				<br>
				<input type="text" name="email" id="email" placeholder="Your email" maxlength="50" required>
				<br><?php if ($errors['email']) { echo '<span class="error-msg">' . $errors['email'] . '</span><br>'; }; ?>

				<label for="username">Username</label>
				<br>
				<input type="text" name="username" id="username" placeholder="Your username" maxlength="30" required>
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

<?php endif; ?>

<?php require('themes/footer.html'); ?>

