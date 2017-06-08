<?php

	session_start();

	if (isset($_SESSION['user']) && isset($_GET['id']) && !empty($_GET['id'])) {

		require_once('includes/bootstrap.php');

		if (isset($_POST['submit']) && !empty($_POST['comment']))
		{
			$conn = App::getDatabase();
			$conn->query('INSERT INTO comments SET id_image = ?, username = ?, comment = ?, created =?',
						 [$_GET['id'], $_SESSION['user'], htmlentities($_POST['comment']), getMyDateFormat()]);
			$owner = $conn->query('SELECT users.email, users.username FROM users INNER JOIN images ON users.username = images.username WHERE images.id = ?',
						 [$_GET['id']])->fetch();

			if ($owner['username'] != $_SESSION['user'])
			{
				// email configuration
				$email = $owner['email'];
				$subject = $_SESSION['user'] . " commented your picture !";
				$header = "From: noreply@camagru.io";
				$message = '			Yo,

				'. $_SESSION['user'] .' has just commented your picture :

				"'. htmlentities($_POST['comment']) .'"

				You can see it with the link below :
				http://localhost:8080/camagru/image.php?id='.urlencode($_GET['id']).'

				---------------

				This is an automatic email.';

				mail($email, $subject, $message, $header) ; // Send the email
			}

		} else if (isset($_POST['submit'])) {
			$error = 'Your comment is not valid';
		}

		$conn = App::getDatabase();
		$pic = $conn->query('SELECT * FROM images WHERE id = ?', [$_GET['id']])->fetch();

		if ($pic) {

			require('themes/header.php');

			?>

			<div class="card align-left">
				<img src="db_image/image-<?php echo $pic['id']; ?>.png" alt="image-<?php echo $pic['id']; ?>">
				<div class="underbar">
				<span class="user">by <?php echo $pic['username']; ?>
					<span class="date"> - <?php echo date('F j, Y - H:i A', strtotime($pic['created']));; ?></span>
				</span>
				<?php if (isset($_SESSION['user'])): ?>
					<ul>
						<li><a href="#" onclick="my_likes_func(<?php echo $pic['id']; ?>)" title="Like it"><i class="fa fa-heart
						<?php

							$find = $conn->query('SELECT * FROM likes WHERE id_user = ? AND id_image = ?', [$_SESSION['user_id'],$pic['id']])->fetch();
							if ($find) { echo "blue"; } else { echo ""; }

						?>" aria-hidden="true"></i></a>
						<?php

							$id = $conn->query('SELECT COUNT(*) FROM likes WHERE id_image = ?', [$pic['id']])->fetchColumn();
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

					$ids = $conn->query('SELECT * FROM comments WHERE id_image = ? ORDER BY created desc', [$_GET['id']])->fetchAll();
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

			<script src="themes/js/func.js"></script>

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
