<?php require_once APP . "/views/master/header.php"; ?>

<?php require_once APP."/views/master/{$_SESSION['session_appname']['level']}_nav.php"; ?>

<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1><?= LANG['info_title'] ?></h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= URL ?>?req=home"><?= LANG['home'] ?></a></li>
						<li class="breadcrumb-item active"><?= LANG['info_title'] ?></li>
					</ol>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-12 col-md-12 col-lg-4 order-1 order-md-1">
								<h3 class="text-dark"><i class="fa-solid fa-skull"></i> <?= APP_NAME ?> <?= VERSION ?></h3>
								<br>
								<div class="text-muted">
									<p class="text-sm"><?= LANG['info_year'] ?>
									  <b class="d-block"><?= YEAR ?></b>
									</p>
									<p class="text-sm"><?= LANG['info_chief'] ?>
										<?php foreach (DEVOPS['name'] as $devop): ?>
											<b class="d-block">• <?= $devop ?></b>
										<?php endforeach ?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-12 col-md-12 col-lg-4 order-1 order-md-1">
								<h3 class="text-dark"><i class="fa-solid fa-book fa-xs"></i> <?= LANG['info_manuals'] ?></h3>
								<ul class="list-unstyled">
									<li>
										<a href="<?= URL ?>" class="btn-link text-secondary">
											<i class="far fa-fw fa-hand-point-right"></i> <?= LANG['info_manual1'] ?>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>


<?php require_once APP."/views/master/footer_js.php"; ?>

<?php require_once APP."/views/master/footer_end.php"; ?>
