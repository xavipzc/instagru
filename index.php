<?php
	
	if ($_GET['USER'] == "xav" && $_GET['PW'] == "test")
	{

?>
	<html><body>
	Bonjour Xav
	</body></html>

<?php

	}
	else
	{
		header('Location: signup.php');
	}

?>
