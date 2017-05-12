<?php 

	try {
		require('config/database.php');
		$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Parse the url
		$username = $_GET['username'];
		$token = $_GET['token'];

		$req = $conn->prepare('SELECT * FROM users WHERE username = ?');
		$req->execute([$username]);
		$user = $req->fetch();

		if ($user && ($user['token'] == $token))
		{
			if ($user['active'] == 0){
				$msg = "Congrats ! Your account is activate !<br>";
				$msg .= 'You can now <a href="login.php">log into our fucking website</a>';
				$conn->prepare("UPDATE users SET active = 1, token = 0 WHERE username = ?")->execute([$username]);
			}
			else {
				$msg = 'Your account is already activate ! <a href="login.php">Log in.</a>';
			}
		}
		else
		{
			$msg = "Error ! Your account can't be activate.";
		}
	}
	catch (PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}

	$conn = null;

?>

<?php 
	require('themes/header.php');
?>

	<h1>Activation</h1>
	<?php echo $msg; ?>


<?php require_once('themes/footer.html'); ?>