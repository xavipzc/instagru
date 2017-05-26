<?php

session_start();

if (!empty($_GET['id']) && isset($_SESSION['user']))
{
	require('config/database.php');
	$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$req = $conn->prepare('SELECT * FROM images WHERE id = ?');
	$req->execute([$_GET['id']]);
	$pic = $req->fetch();

	if ($pic)
	{
		$req = $conn->prepare('SELECT * FROM likes WHERE id_user = ? AND id_image = ?');
		$req->execute([$_SESSION['user_id'] ,$_GET['id']]);
		$like = $req->fetch();

		if ($like) {
			$req = $conn->prepare('DELETE FROM likes WHERE id_user = ? AND id_image = ?');
			$req->execute([$_SESSION['user_id'] ,$_GET['id']]);
		} else {
			$req = $conn->prepare('INSERT INTO likes SET id_user = ?, id_image = ?');
			$req->execute([$_SESSION['user_id'] ,$_GET['id']]);
		}
		header('Location: timeline.php');
	}
	header('Location: timeline.php');
}
header('Location: timeline.php');

?>
