<?php 

	session_start();
	require('themes/header.php');

?>
<?php if (isset($_SESSION['user'])): ?>

		<h1>The gallery</h1>
		<p>Hello <?php echo ucfirst($_SESSION['user']); ?></p>

<?php else: ?>

		<h1>The gallery</h1>
		<div class="box-blue">
			Hi, you have to be connected to comment and like pictures. <a href="signup.php">Sign up</a> or <a href="login.php">Log in</a>
		</div>

<?php endif; ?>

		<div class="card align-left">
			<!-- img -->
			<div class="underbar">
				<span class="user">by boloss</span>
				<?php if (isset($_SESSION['user'])): ?>
					<ul>
						<li><a href="" title="Comment it"><i class="fa fa-comment" aria-hidden="true"></i></a></li>
						<li><a href="" title="Like it"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a></li>
					</ul>
				<?php endif; ?>
			</div>
		</div>

		<div class="card align-left">
			<!-- img -->
			<div class="underbar">
				<span class="user">by boloss</span>
				<?php if (isset($_SESSION['user'])): ?>
					<ul>
						<li><a href="" title="Comment it"><i class="fa fa-comment" aria-hidden="true"></i></a></li>
						<li><a href="" title="Like it"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a></li>
					</ul>
				<?php endif; ?>
			</div>
		</div>

		<div class="clear"></div>

<?php require_once('themes/footer.html'); ?>