<?php 
	
	require('config/database.php');

	try {
		$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Parse the url
		$user = $_GET['username'];
		$token = $_GET['token'];

		// Get the token from the get user in the database
		$stmt = $conn->prepare("SELECT token,active FROM users WHERE username like :username");
		if ($stmt->execute(array(':username' => $user)) && $row = $stmt->fetch())
		{
			$tokendb = $row['token'];
			$active = $row['active'];
		}

		// Check if the account is already active
		if($active == '1')
		{
			$msg = 'Your account is already activate ! <a href="login.php">Log in.</a>';
		}
		else
		{
			// Comparaison, if it's true, activation of the account
			if ($token == $tokendb)
			{
				$msg = "Congrats ! Your account is activate !<br>";
				$msg .= 'You can now <a href="login.php">log into our fucking website</a>';
				$stmt = $conn->prepare("UPDATE users SET active = 1 WHERE username like :username");
				$stmt->bindParam(':username', $user);
				$stmt->execute();
			}
			else
			{
				$msg = "Error ! Your account can't be activate.";
			}
		}
	}
	catch (PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}

	$conn = null;

?>

<?php 
	require_once('themes/header.html');
	require_once('themes/navbar.html');
?>

<div class="container">

	<h1>Activation</h1>
	<?php echo $msg; ?>

</div>

<?php require_once('themes/footer.html'); ?>