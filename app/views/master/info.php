<?php require_once APP . "/views/master/header.php"; ?>

<?php require_once APP."/views/master/{$_SESSION['log']['level']}-nav.php"; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Detalles del sistema</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= URL ?>?req=home">Inicio</a></li>
						<li class="breadcrumb-item active">Info</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-12">
				<!-- Default box -->
				<div class="card">
					<div class="card-header bg-dark">
						<h3 class="card-title"><?= APP_NAME ?> | Información del sistema</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
							<i class="fas fa-minus"></i></button>
							<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
							<i class="fas fa-times"></i></button>
						</div>
					</div>
					<div class="card-body">
						<ul class="list-group display-7">
							<li class="list-group-item"><strong>Año oficial de lanzamiento:</strong> <?= YEAR ?></li>
							<li class="list-group-item"><strong>Versión:</strong> <?= VERSION ?></li>
							<li class="list-group-item">
								<strong>Desarrollado por: </strong><br>
								<ul>
								<?php foreach (DEVOPS['name'] as $key => $name): ?>
								<li style="list-style:none;">
								<i class="fas fa-angle-double-right mr-2"></i> <?= $name ?> /
								<a href="mailto:<?= DEVOPS['mail'][$key] ?>?subject=Hi!"><?= DEVOPS['mail'][$key] ?></a>
								</li>
								<?php endforeach ?>
								</ul>
							</li>
							<li class="list-group-item">
								<form action="<?= URL ?>internal_data" method="post" accept-charset="utf-8">
									<div class="form-row">
										<div class="col-12 col-sm-12 col-md-10">
											<div class="form-group">
												<input type="text" class="form-control" id="comment" name="comment" placeholder="Escribe aqui tus comentarios" autofocus required>
											</div>
										</div>
										<div class="col-12 col-sm-12 col-md-2">
											<button type="submit" class="form-control btn btn-primary float-right" name="newComment">
												<i class="far fa-paper-plane"></i> Enviar
											</button>
										</div>
									</div>
								</form>
							</li>
						</ul>
					</div>
				</div>
				<!-- /.card -->
			</div>
		</div>
		<!-- ./ Row -->
		<div class="row">
			<div class="col-12">
				<div class="card direct-chat direct-chat-dark">
					<div class="card-header bg-dark">
						<h3 class="card-title">Comentarios</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
						</div>
					</div>
					<!-- ./card-header -->
					<div class="card-body">
						<div class="direct-chat-messages">
							<?php $objHome->showComments() ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- REQUIRED SCRIPTS -->

<?php require_once APP."/views/master/footer_js.php"; ?>

<?php require_once APP."/views/master/footer_end.php"; ?>
