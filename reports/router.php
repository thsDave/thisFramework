<?php

require_once "../app/config/config.php";

if (isset($_POST['print']))
{
	$_SESSION['data_report']['side'] = (isset($_POST['side'])) ? 'l' : 'p';

	if ($_POST['print'] == 'pdf')
		header("Location: ".URL.$_POST['report']);
	else
		header("Location: ".URL."xls_report?xls_req={$_POST['report']}");
}
else
{
	header("Location: 404");
}