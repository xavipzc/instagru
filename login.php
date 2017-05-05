<?php require_once('themes/header.html'); ?>

<div class="container log-in">

	<div class="encart">
		<h1 class="align-center">
			<i class="fa fa-instagram" aria-hidden="true"></i> Camagru
		</h1>

		<form action="" method="POST" class="align-center">

			<label for="username">Username</label>
			<br>
			<input type="text" name="username" id="username" placeholder="Your username" required>
			<br>

			<label for="passwd">Password</label>
			<br>
			<input type="password" name="passwd" id="passwd" placeholder="Your password" required>
			<br>			

			<input type="submit" name="submit" value="Log in" class="btn btn-blue">
			<?php echo $msg; ?>
			
		</form>

		<p class="align-center forgot">
			<a href="reset.php">Forgot your password ?</a>
		</p>

		<div class="separator"></div>

		<p class="align-center">
			Don't have an account ? <a href="signup.php">Sign up</a>
		</p>

	</div>
</div>
	
</div>

<?php require_once('themes/footer.html'); ?>