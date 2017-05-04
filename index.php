<?php
	
	if ($_SERVER['PHP_AUTH_USER'] == "xav" && $_SERVER['PHP_AUTH_PW'] == "test")
	//if ($_GET['USER'] == "xav" && $_GET['PW'] == "test")
	{

?>
	<html><body>
	Bonjour Xav
	</body></html>

<?php

	}
	else
	{
		header("WWW-Authenticate: Basic realm=''Espace membres''");
		header('HTTP/1.0 401 Unauthorized');
	}

?>
