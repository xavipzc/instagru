<?php 

	// INIT DATABASE

	// database infos
	require('database.php');
	// connect to Mysql without database
	$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	// database request init
	$request = "CREATE DATABASE IF NOT EXISTS `".$DB_NAME."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
	// prepare and execute the request
	$pdo->prepare($request)->execute();


	// INIT TABLES

	// connection to database
	$connection = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
	 
	// check if connection is ok
	if ($connection){
		// table request init
		$request = "CREATE TABLE IF NOT EXISTS `".$DB_NAME."`.`users` (
					`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`email` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					`username` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					`password` CHAR( 128 ) NOT NULL ,
					`salt` CHAR( 128 ) NOT NULL ,
					`created` DATETIME NOT NULL
					) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
	 
		$connection->prepare($request)->execute();
	}

?>