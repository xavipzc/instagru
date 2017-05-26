<?php

session_start();

$image = (isset($_POST["image"])) ? $_POST["image"] : NULL;

if ($image) {

	if (!file_exists("db_image")) { mkdir("db_image", 0755); }

	try {
		require('config/database.php');
		$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = $conn->prepare("SELECT COUNT(*) FROM images");
		$sql->execute();
		$id = $sql->fetchColumn();

		if ($id === 0) {
			$id = 1;
		} else {
		 	$id += 1;
		}

		date_default_timezone_set("Europe/Paris");
		$date = date('Y-m-d H:i:s');
		$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
		file_put_contents('db_image/image-'.$id.'.png', $image);

		$sql = $conn->prepare("INSERT INTO images SET username = ?, name = ?, created = ?");
		$sql->execute([$_SESSION['user'], 'image-'.$id.'', $date]);

		echo '<i class="fa fa-check-circle green" aria-hidden="true"></i> Your picture was successfully added !';
	}
	catch (PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}

	$conn = null;
}
else {
	echo '<i class="fa fa-times-circle red" aria-hidden="true"></i> Something went wrong, please retry or contact the admin.';
}

?>
