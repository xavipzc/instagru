<?php

	if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['passwd']) && !empty($_POST['passwd_confirm']))
	{
		if ($_POST['passwd'] === $_POST['passwd_confirm'])
		{
				require_once('includes/bootstrap.php');

				$conn = App::getDatabase();
				$passwd = hash(whirlpool, $_POST['passwd']);
				$conn->query("UPDATE users SET password = ?, token = '0' WHERE username = ?", [$passwd, $_POST['username']]);
				header('Location: login.php');
		}
	}
	else {
		header('Location: 404.php');
	}

?>
