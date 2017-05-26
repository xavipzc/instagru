<?php

	session_start();
	require_once('includes/bootstrap.php');

	$image = (isset($_POST["image"])) ? $_POST["image"] : NULL;

	if ($image) {

		if (!file_exists("db_image")) { mkdir("db_image", 0755); }

		$conn = App::getDatabase();
		$id = $conn->query("SELECT COUNT(*) FROM images")->fetchColumn();

		if ($id === 0) { $id = 1; } else { $id += 1; }

		$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
		file_put_contents('db_image/image-'.$id.'.png', $image);

		$conn->query("INSERT INTO images SET username = ?, name = ?, created = ?",
					 [$_SESSION['user'], 'image-'.$id.'', getMyDateFormat()]);

		echo '<i class="fa fa-check-circle green" aria-hidden="true"></i> Your picture was successfully added !';
	}
	else {
		echo '<i class="fa fa-times-circle red" aria-hidden="true"></i> Something went wrong, please retry or contact the admin.';
	}

?>
