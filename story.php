<?php

	session_start();
	require_once('includes/bootstrap.php');

?>
<?php if (isset($_SESSION['user'])): require('themes/header.php'); ?>

	<h1>My story</h1>
	<p>Hey <?php echo ucfirst($_SESSION['user']); ?> you can use your webcam to start telling your story or upload your own pictures.</p>

	<div class="cam align-left">

		<div id="choosefile" class="hidden">
			<input id="file" type="file" class="inputfile" />
			<label for="file"><i class="fa fa-upload" aria-hidden="true"></i> Choose a file</label>
		</div>

		<video id="video"></video>

		<div class="sticker-select">
			<label for="stickers-list">Change sticker</label><br>
			<select name="stickers-list" id="stickers-list">
				<option value="thug">Thug</option>
				<option value="thug2">Thug 2</option>
				<option value="moustache">Moustache</option>
				<option value="filter1">Filter 1</option>
			</select>
		</div>

		<button id="cancel-upload" class="btn btn-red hidden">Cancel</button>

		<img src="themes/img/stickers/thug.png" width="400px" height="300px" id="sticker">
		<button id="startbutton" class="btn btn-blue">Take a picture</button>
	</div>
	<div class="align-left">
		<canvas id="canvas"></canvas>
		<br><span id="message"></span>
	</div>

	<div class="clear"></div>

	<div class="separator"></div>

	<div class="gallery">

		<?php

			$conn = App::getDatabase();
			$pics = $conn->query('SELECT * FROM images WHERE username = ? ORDER BY id desc', [$_SESSION['user']])->fetchAll();

			if ($pics) {
				foreach ($pics as $key => $value) { ?>
					<div class="card align-left">
					<img src="db_image/image-<?php echo $value['id']; ?>.png" alt="image-<?php echo $value['id']; ?>">
					<div class="underbar">
						<span class="user">
							<span class="date"><?php echo date('F j, Y - H:i A', strtotime($value['created']));; ?></span>
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
								<li><a href="delete.php?id=<?php echo $value['id']; ?>" onclick="if(confirm('You really want to delete this ?')){ document.location.href = url;} else {}" title="Delete it"><i class="fa fa-trash red" aria-hidden="true"></i></a></li>
							</ul>
						<?php endif; ?>
					</div>
				</div>
				<?php
				}
			}

		?>

				<div class="clear"></div>

	</div>

	<script src="themes/js/func.js"></script>
	<script src="themes/js/camagru.js"></script>

<?php require('themes/footer.html'); else: header('Location: 404.php'); ?>

<?php endif; ?>
