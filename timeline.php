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

<?php

	require('config/database.php');
	$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$req = $conn->prepare('SELECT * FROM images ORDER BY id desc');
	$req->execute();
	$pics = $req->fetchAll();

	if ($pics) {
		foreach ($pics as $key => $value) { ?>
			<div class="card align-left">
			<img src="db_image/<?php echo $value['name']; ?>.png" alt="<?php echo $value['name']; ?>">
			<div class="underbar">
				<span class="user">by <?php echo $value['username']; ?>
					<span class="date"> - <?php echo date('F j, Y - H:i A', strtotime($value['created']));; ?></span>
				</span>
				<?php if (isset($_SESSION['user'])): ?>
					<ul>
						<li><a href="image.php?id=<?php echo $value['id']; ?>" title="Comment it"><i class="fa fa-comment" aria-hidden="true"></i>
						<?php

							$req = $conn->prepare('SELECT COUNT(*) FROM comments WHERE id_image = ?');
							$req->execute([$value['id']]);
							$com = $req->fetchColumn();
							if ($com) { echo '<span class="count">'.$com.'</span>'; } else { echo ""; }

						?>
						</a>
						</li>
						<li><a href="like.php?id=<?php echo $value['id']; ?>" title="Like it"><i class="fa fa-heart
						<?php

							$req = $conn->prepare('SELECT * FROM likes WHERE id_user = ? AND id_image = ?');
							$req->execute([$_SESSION['user_id'],$value['id']]);
							$find = $req->fetch();
							if ($find) { echo "blue"; } else { echo ""; }

						?>" aria-hidden="true"></i>
						<?php

							$req = $conn->prepare('SELECT COUNT(*) FROM likes WHERE id_image = ?');
							$req->execute([$value['id']]);
							$id = $req->fetchColumn();
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

<?php require_once('themes/footer.html'); ?>
