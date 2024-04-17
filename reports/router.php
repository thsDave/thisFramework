<?php

require_once "../app/config/config.php";
require_once "../app/controllers/HomeController.php";

if (isset($_POST['print']))
{
	$_SESSION['data_report']['side'] = (isset($_POST['side'])) ? 'l' : 'p';

	if ($_POST['print'] == 'pdf') {
		$model->savelog(2, "Se realizó la impresión de reporte '{$_POST['report']}' en formato pdf", $_SESSION[USER_SESSION]['id']);
		header("Location: ".URL.$_POST['report']);
	}else {
		$model->savelog(2, "Se realizó la impresión de reporte '{$_POST['report']}' en formato xls", $_SESSION[USER_SESSION]['id']);
		header("Location: ".URL."xls_report?xls_req={$_POST['report']}");
	}
}
else
{
	header("Location: 404");
}