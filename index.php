<?php
	
	session_start();

	require('config/database.php');
	$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$req = $pdo->prepare('SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?');
	$req->execute(array('camagru'));

	if ($req->fetchColumn() == 0) {

		if ($_SESSION['user']) {
			session_destroy();
		}

		echo "The database doesn't exist, please launch the config/setup.php file";

	}

	else {

		if ($_SESSION['user'])
		{
			header("Location: timeline.php");
		}
		else
		{
			header("Location: login.php");
		}

	}

?>
