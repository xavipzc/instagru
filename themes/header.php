<?php

if (session_status() == PHP_SESSION_NODE)
{
	session_start();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Camagru - The Instagram like</title>

	<!-- Stylesheets -->
	<link rel="stylesheet" href="themes/css/style.css">

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700|Pacifico" rel="stylesheet">
	<link href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
	
	<!-- Favicon -->
	<link href="themes/img/42.png" rel="icon" type="image/svg">
</head>
<body>

<nav>
	<a href="index.php" id="logo" class="align-left">
		<i class="fa fa-instagram" aria-hidden="true"></i> Camagru
	</a>
	<ul class="align-right">

		<?php if (isset($_SESSION['user'])): ?>
			<li><span>Hello <?php echo ucfirst($_SESSION['user']); ?>,</span></li>
		<?php endif; ?>
		<li><a href="timeline.php"><i class="fa fa-search" aria-hidden="true"></i> Search</a></li>
		<li><a href="timeline.php">Gallery</a></li>
		<?php if (isset($_SESSION['user'])): ?>
			<li><a href="story.php">My story</a></li>
			<li><a href="logout.php" class="btn btn-red">Log out</a></li>
		<?php else: ?>
			<li><a href="login.php" class="btn btn-blue">Log in</a></li>
		<?php endif; ?>
		
	</ul>
	<div class="clear"></div>
</nav>

<div class="container">