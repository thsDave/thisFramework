<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title><?= LANG['reports_title'] ?></title>
		<?php include 'styles_css.php'; ?>
	</head>
	<body>
		<div class="row">
			<div class="col-12">
				<img src="<?= URL ?>dist/img/logo.png" width="83" height="83">
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<h1><?= LANG['report_card1_title'] ?></h1>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-12">
				<table class="table table-bordered table-striped">
					<thead>
						<tr class="trhead">
							<td>No</td>
							<td><?= LANG['field_name'] ?></td>
							<td><?= LANG['field_email'] ?></td>
							<td><?= LANG['field_lang'] ?></td>
							<td><?= LANG['field_status'] ?></td>
						</tr>
					</thead>
					<?php $data = $model->user_list(); ?>
					<tbody>
						<?php if ($data): ?>
						<?php foreach ($data['id'] as $i => $val): ?>
						<tr>
							<td><?= $i + 1 ?></td>
							<td><?= $data['name'][$i] ?></td>
							<td><?= $data['email'][$i] ?></td>
							<td><?= $data['language'][$i] ?></td>
							<td><?= $data['status'][$i] ?></td>
						</tr>
						<?php endforeach ?>
						<?php else: ?>
						<tr><td colspan="7"><p><?= LANG['field_empty_table'] ?></p></td></tr>
						<?php endif ?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>