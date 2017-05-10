<?php 

	if (isset($_POST['submit']))
	{
		$username = $_POST['username'];

		require('config/database.php');

		try {
			$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt = $conn->prepare("SELECT email,active FROM users WHERE username like :username");
			if ($stmt->execute(array(':username' => $username)) && $row = $stmt->fetch())
			{
				$email = $row['email'];
				$active = $row['active'];
			}

			if ($email)
			{
				if ($active == 1)
				{
					$token = hash(sha1, $date);
					$sql = "UPDATE users SET token = '$token' WHERE username like '$username'";
				
					// use exec() because no results are returned
					$conn->exec($sql);

					// Préparation du mail contenant le lien d'activation
					$sujet = "Reset your password";
					$entete = "From: noreply@camagru.io";
					 
					// Le lien d'activation est composé du login(log) et de la clé(cle)
					$message = '			Hello,
					 
					You forgot your password, if you want to change it please
					follow the link bellow or copy/paste the link into your browser.
					 
					http://localhost:8080/camagru/change.php?username='.urlencode($username).'&token='.urlencode($token).'
					 
					---------------

					This is an automatic email.';

					mail($email, $sujet, $message, $entete) ; // Envoi du mail

					$msg = 'An email has been sent to your inbox !';
				}
				else { $msg = 'This account is not activate'; }
			}
			else { $msg = 'This username doesn\'t exist'; }
		}
		catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}

		$conn = null;
	}

?>
<?php
	require_once('themes/header.html');

	if ($_SESSION['user'])
		require_once('themes/navbar_logged.html');
	else
		require_once('themes/navbar.html');
?>

<div class="container log-in">

	<div class="encart">
		<h1 class="align-center">
			<i class="fa fa-instagram" aria-hidden="true"></i> Camagru
		</h1>

		<form action="reset.php" method="POST" class="align-center">
			
			<p class="align-center">
				Enter your username to reset your password.
			</p>

			<input type="text" name="username" id="username" placeholder="Your username" required>
			<br>		

			<input type="submit" name="submit" value="Reset password" class="btn btn-blue">
			<?php echo $msg; ?>
			
		</form>

		<p class="align-center forgot">
			<a href="login.php">Log in if you know it.</a>
		</p>

	</div>
</div>
	
</div>

<?php require_once('themes/footer.html'); ?>
