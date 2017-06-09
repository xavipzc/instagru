<?php

	session_start();
	require_once('includes/bootstrap.php');
	
	$conn = App::getDatabase();
	$allpics = $conn->query('SELECT * FROM images ORDER BY id desc')->fetchAll();
	$a = ceil(sizeof($allpics) / 6);

	if (isset($_GET['page']) && !ctype_digit($_GET['page'])) {
		header('Location: 404.php');
		die();
	} else {
		$page = $_GET['page'];
		if ($page == "" || $page == "0" || $page == "1") {
			$page1 = 0;
		} elseif ($page > $a) {
			header('Location: 404.php');
			die();
		} else {
			$page1 = ($page * 6) - 6;
		}
	}

	require('themes/header.php');

?>
<?php if (isset($_SESSION['user'])): ?>

		<h1>The World's Wall</h1>
		<form action="" method="POST">
			<input type="text" name="search" id="search" placeholder="Type an username to filter" maxlength="30" required>
			<input type="submit" name="submit" class="btn btn-blue search" value="Search">
		</form>

<?php else: ?>

		<h1>The Wall</h1>
		<div class="box-blue">
			Hi, you have to be connected to comment and like pictures. <a href="signup.php">Sign up</a> or <a href="login.php">Log in</a>
		</div>

<?php endif; ?>

<?php

	if (!empty($_POST) && !empty($_POST['search'])) {
		$user = $conn->query('SELECT * FROM users WHERE username = ?', [$_POST['search']])->fetch();
		if ($user) {
			$page = false;
			$pics = $conn->query('SELECT * FROM images WHERE username = ? ORDER BY id desc', [$_POST['search']])->fetchAll();
			echo '<p>Looking for '.ucfirst(htmlentities($_POST['search'])).' pictures : </p>';
		} else {
			$page = true;
			$pics = $conn->query('SELECT * FROM images ORDER BY id desc LIMIT '.$page1.',6')->fetchAll();
			echo "<span class=\"error-msg\">". htmlentities($_POST['search']) ." doesn't exist</span><br>";
		}
	} else {
		$pics = $conn->query('SELECT * FROM images ORDER BY id desc LIMIT '.$page1.',6')->fetchAll();
		$page = true;
	}

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
						<li><a href="" onclick="my_likes_func(<?php echo $value['id']; ?>, this)" title="Like it"><i class="fa fa-heart
						<?php

							$find = $conn->query('SELECT * FROM likes WHERE id_user = ? AND id_image = ?', [$_SESSION['user_id'],$value['id']])->fetch();
							if ($find) { echo "blue"; } else { echo ""; }

						?>" aria-hidden="true"></i>
						<?php

							$id = $conn->query('SELECT COUNT(*) FROM likes WHERE id_image = ?', [$value['id']])->fetchColumn();
							if ($id) { echo '<span class="count">'.$id.'</span>'; } else { echo '<span class="count"></span>'; }

						?>
						</a>
						</li>
					</ul>
				<?php endif; ?>
			</div>
		</div>
		<?php
		}

		?>	
			<div class="clear"></div>
			<script src="themes/js/func.js"></script>
		<?php

		if ($page) {
			?><div class="pagination">Page : <?php
			for ($b = 1; $b <= $a; $b++) {
				?><a href="timeline.php?page=<?php echo $b; ?>"><?php echo $b." "; ?></a><?php
			}					
		}
		?></div><?php
	} else {
		echo "There is no images yet. Be the first !";
	}

?>

<?php require('themes/footer.html'); ?>
