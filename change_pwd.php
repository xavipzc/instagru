<?php
	
	if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['passwd']) && !empty($_POST['passwd_confirm']))
	{
		if ($_POST['passwd'] == $_POST['passwd_confirm'])
		{
			try {
				require('config/database.php');
				$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = $conn->prepare("UPDATE users SET password = ?, token = '0' WHERE username = ?");
				$passwd = hash(whirlpool, $_POST['passwd']);
				$sql->execute([$passwd, $_POST['username']]);
				header('Location: login.php');
			}
			catch (PDOException $e) {
				echo $sql . "<br>" . $e->getMessage();
			}

			$conn = null;
		}
	}

?>