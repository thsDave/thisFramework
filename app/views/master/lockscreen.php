<?php require_once APP . "/views/master/header_lockscreen.php"; ?>

<script src="https://www.google.com/recaptcha/api.js?render=<?= WEBKEY ?>"></script>

	<div class="lockscreen-logo">
		<img src="dist/img/logo2.png" class="w-25">
	</div>

	<div class="lockscreen-name"><?= $_SESSION[USER_SESSION]['name'] ?></div>

	<div class="lockscreen-item">

		<div class="lockscreen-image">
			<img src="data:image/png;base64,<?= $_SESSION[USER_SESSION]['pic'] ?>" alt="User profile picture">
		</div>

		<form id="lockscreen-form" class="lockscreen-credentials">
			<div class="input-group">
				<input type="password" id="password" name="password" class="form-control" placeholder="password" required autofocus>
				<div class="input-group-append">
					<button type="submit" class="btn">
						<i class="fas fa-arrow-right text-muted"></i>
					</button>
				</div>
			</div>
		</form>

	</div>

	<div class="help-block text-center">
		<?= LANG['lock_mssg'] ?>
	</div>

	<div class="text-center">
		<a href="<?= URL ?>?event=logout"><?= LANG['lock_login'] ?></a>
	</div>

	<div class="lockscreen-footer text-center">
		<?= APP_NAME ?>
	</div>

<?php require_once APP."/views/master/footer_js.php"; ?>

<script src="dist/js/lockscreen.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>
