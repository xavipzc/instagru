<?php

	session_start();

	if (isset($_SESSION['user']) && isset($_GET['id']) && !empty($_GET['id'])) {

		require('themes/header.php');

		if (isset($_POST['submit']) && !empty($_POST['comment']))
		{
			try {
				require('config/database.php');
				$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				date_default_timezone_set("Europe/Paris");
				$date = date('Y-m-d H:i:s');
				$req = $conn->prepare("INSERT INTO comments SET id_image = ?, username = ?, comment = ?, created =?");
				$req->execute([$_GET['id'], $_SESSION['user'], htmlentities($_POST['comment']), $date]);
			}
			catch (PDOException $e) {
				echo $req . "<br>" . $e->getMessage();
			}

			$conn = null;
		} else if (isset($_POST['submit'])) {
			$error = 'Your comment is not valid';
		}

		require('config/database.php');
		$conn = new PDO($DB_DSN.";dbname=".$DB_NAME, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$req = $conn->prepare('SELECT * FROM images WHERE id = ?');
		$req->execute([$_GET['id']]);
		$pic = $req->fetch();

		if ($pic) { ?>

			<div class="card align-left">
				<img src="db_image/<?php echo $pic['name']; ?>.png" alt="<?php echo $pic['name']; ?>">
				<div class="underbar">
				<span class="user">by <?php echo $pic['username']; ?>
					<span class="date"> - <?php echo date('F j, Y - H:i A', strtotime($pic['created']));; ?></span>
				</span>
				<?php if (isset($_SESSION['user'])): ?>
					<ul>
						<li><a href="like.php?id=<?php echo $pic['id']; ?>" title="Like it"><i class="fa fa-heart
						<?php

							$req = $conn->prepare('SELECT * FROM likes WHERE id_user = ? AND id_image = ?');
							$req->execute([$_SESSION['user_id'],$pic['id']]);
							$find = $req->fetch();
							if ($find) { echo "blue"; } else { echo ""; }

						?>" aria-hidden="true"></i></a>
						<?php

							$req = $conn->prepare('SELECT COUNT(*) FROM likes WHERE id_image = ?');
							$req->execute([$pic['id']]);
							$id = $req->fetchColumn();
							if ($id) { echo '<span class="count">'.$id.'</span>'; } else { echo ""; }

						?>
						</li>
					</ul>
				<?php endif; ?>
				</div>
			</div>

			<div class="comments align-left">
				<form action="" method="POST">
					<textarea name="comment" id="comment" placeholder="Your 255 characters max comment.." maxlength="255" required></textarea>
					<input type="submit" name="submit" value="Submit" class="btn btn-blue">
					<br><?php if ($error) { echo '<span class="error-msg">' . $error . '</span><br>'; }; ?>
				</form>

				<p>Comments</p>

				<?php

					$req = $conn->prepare('SELECT * FROM comments WHERE id_image = ? ORDER BY created desc');
					$req->execute([$_GET['id']]);
					$ids = $req->fetchAll();
					if ($ids):
						foreach ($ids as $key => $com) { ?>

							<div class="comment">
							<p><?php echo $com['comment']; ?></p>
								<p class="comment-title">
									<?php echo $com['username']; ?> -
									<span class="date">
									<?php echo date('F j, Y - H:i A', strtotime($com['created']));; ?>
									</span>
								</p>
							</div>

					<?php } else: ?>
						<p>Be the first to comment it !</p>
					<?php endif; ?>
			</div>

			<div class="clear"></div>

		<?php }

		else {
			header('Location: 404.php');
		}

		require('themes/footer.html');
	}
	else {
		header('Location: 404.php');
	}

?>
