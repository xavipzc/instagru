<?php

	session_start();
	if (isset($_SESSION['user']) && isset($_GET['id']) && !empty($_GET['id'])){
		require_once('includes/bootstrap.php');

		$conn = App::getDatabase();
		$img = $conn->query('SELECT * FROM images WHERE id = ?', [$_GET['id']])->fetch();

		if ($img)
		{
			$conn->query('DELETE FROM images WHERE id = ?', [$_GET['id']]);
			unlink('db_image/image-'.$_GET['id'].'.png');
			header('Location: story.php');
		}
		else {
			header('Location: 404.php');
		}
	}
	else {
		header('Location: 404.php');
	}

?>
