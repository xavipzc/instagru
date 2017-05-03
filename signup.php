<?php require_once('themes/header.html'); ?>

<div class="container log-in">

	<div class="encart">
		<h1 class="align-center">
			<i class="fa fa-instagram" aria-hidden="true"></i> Camagru
		</h1>
		<p class="align-center">
			Sign up to see photos from your friends.
		</p>

		<div class="separator"></div>

		<form action="" method="POST" class="align-center">

			<label for="email">Email</label>
			<br>
			<input type="text" name="email" id="email" placeholder="Your email" required>
			<br>
			
			<label for="username">Username</label>
			<br>
			<input type="text" name="username" id="username" placeholder="Your username" required>
			<br>

			<label for="passwd">Password</label>
			<br>
			<input type="password" name="passwd" id="passwd" placeholder="Choose a password" required>
			<br>			

			<input type="submit" name="submit" value="Sign Up" class="btn btn-blue">
			<?php echo $msg; ?>	
			
		</form>

		<div class="separator"></div>

		<p class="align-center">
			Have an account ? <a href="login.php">Log in</a>
		</p>

	</div>
</div>
	
</div>

<?php require_once('themes/footer.html'); ?>