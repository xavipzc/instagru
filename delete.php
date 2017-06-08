<?php

	session_start();
	if (isset($_SESSION['user']) && isset($_GET['id']) && !empty($_GET['id'])){
		require_once('includes/bootstrap.php');

		$conn = App::getDatabase();
		$img = $conn->query('SELECT * FROM images WHERE id = ? AND username = ?', [$_GET['id'], $_SESSION['user']])->fetch();

		if ($img)
		{
			$likes = $conn->query('SELECT * FROM likes WHERE id_image = ?', [$_GET['id']])->fetch();
			if ($likes) {
				$conn->query('DELETE FROM likes WHERE id_image = ?', [$_GET['id']]);
			}
			$coms = $conn->query('SELECT * FROM comments WHERE id_image = ?', [$_GET['id']])->fetch();
			if ($coms) {
				$conn->query('DELETE FROM comments WHERE id_image = ?', [$_GET['id']]);
			}
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
