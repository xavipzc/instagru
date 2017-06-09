<?php

session_start();

if (!empty($_GET['id']) && isset($_SESSION['user']))
{
	require_once('includes/bootstrap.php');
	$conn = App::getDatabase();
	$pic = $conn->query('SELECT * FROM images WHERE id = ?', [$_GET['id']])->fetch();

	if ($pic)
	{
		$like = $conn->query('SELECT * FROM likes WHERE id_user = ? AND id_image = ?',
							[$_SESSION['user_id'] ,$_GET['id']])->fetch();

		if ($like) {
			$conn->query('DELETE FROM likes WHERE id_user = ? AND id_image = ?',
						[$_SESSION['user_id'] ,$_GET['id']]);
		} else {
			$conn->query('INSERT INTO likes SET id_user = ?, id_image = ?',
						[$_SESSION['user_id'] ,$_GET['id']]);
		}

		$id = $conn->query('SELECT COUNT(*) FROM likes WHERE id_image = ?', [$_GET['id']])->fetchColumn();
		$find = $conn->query('SELECT * FROM likes WHERE id_user = ? AND id_image = ?', [$_SESSION['user_id'],$pic['id']])->fetch();

		if ($find) { echo $id . ",1"; } else { echo $id . ",0"; }
		
	}
}

?>
