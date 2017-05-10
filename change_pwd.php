<?php
	
	if (isset($_POST['submit']) && isset($_POST['passwd']))
	{
		$username = $_POST['username'];
		$passwd = hash(whirlpool, $_POST['passwd']);

		require('config/database.php');

		try {
			$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sql = "UPDATE users SET password = '$passwd', token = '0' WHERE username like '$username'";
			$conn->exec($sql);

			header('Location: login.php');
		}
		catch (PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}

		$conn = null;
	}

?>