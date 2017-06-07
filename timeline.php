<?php

	session_start();
	require('themes/header.php');
	require_once('includes/bootstrap.php');

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

<?php

	$conn = App::getDatabase();
	$pics = $conn->query('SELECT * FROM images ORDER BY id desc')->fetchAll();

	if ($pics) {
		foreach ($pics as $key => $value) { ?>
			<div class="card align-left">
			<img src="db_image/image-<?php echo $value['id']; ?>.png" alt="image-<?php echo $value['id']; ?>">
			<div class="underbar">
				<span class="user">by <?php echo $value['username']; ?>
					<span class="date"> - <?php echo date('F j, Y - H:i A', strtotime($value['created']));; ?></span>
				</span>
				<?php if (isset($_SESSION['user'])): ?>
					<ul>
						<li><a href="image.php?id=<?php echo $value['id']; ?>" title="Comment it"><i class="fa fa-comment" aria-hidden="true"></i>
						<?php

							$com = $conn->query('SELECT COUNT(*) FROM comments WHERE id_image = ?', [$value['id']])->fetchColumn();
							if ($com) { echo '<span class="count">'.$com.'</span>'; } else { echo ""; }

						?>
						</a>
						</li>
						<li><a href="like.php?id=<?php echo $value['id']; ?>" title="Like it"><i class="fa fa-heart
						<?php

							$find = $conn->query('SELECT * FROM likes WHERE id_user = ? AND id_image = ?', [$_SESSION['user_id'],$value['id']])->fetch();
							if ($find) { echo "blue"; } else { echo ""; }

						?>" aria-hidden="true"></i>
						<?php

							$id = $conn->query('SELECT COUNT(*) FROM likes WHERE id_image = ?', [$value['id']])->fetchColumn();
							if ($id) { echo '<span class="count">'.$id.'</span>'; } else { echo ""; }

						?>
						</a>
						</li>
					</ul>
				<?php endif; ?>
			</div>
		</div>
		<?php
		}
	}

?>

		<div class="clear"></div>

<?php require('themes/footer.html'); ?>
