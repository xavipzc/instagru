<?php
	
	session_start();

	if ($_SESSION['user'])
	{
		header("Location: timeline.php");
	}
	else
	{
		header("Location: login.php");
	}

?>
