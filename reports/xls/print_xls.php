<?php
require_once "../main.php";

//Niveles permitidos
$levels = [ 'Super', 'Admin' ];

if (in_array($_SESSION['session_appname']['level'], $levels))
{
	$arr_docs = [
		'users_list' => LANG['report_name_doc_users'].date("dmY-His"),
		'support_list' => LANG['report_name_doc_support'].date("dmY-His")
	];

	if (isset($_GET['xls_req']) && isset($arr_docs[$_GET['xls_req']])) { $view = $_GET['xls_req']; }

	if (isset($view))
	{
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename={$arr_docs[$view]}.xls");

		ob_start();

		include $view.'.php';

		unset($_SESSION['data_report']);
	}
	else
	{
		header("Location: ".URL);
	}
}
else
{
	header('Location: 404');
}