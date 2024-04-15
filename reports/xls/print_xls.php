<?php
require_once "../main.php";

//Niveles permitidos
$levels = [ 'Super', 'Admin' ];

if (in_array($_SESSION[USER_SESSION]['level'], $levels))
{
	$reports = [
		'user_report',
		'support_report'
	];

	$arr_docs = [
		'user_report' => 'xls_users',
		'support_report' => 'xls_supports'
	];

	if (isset($_GET['xls_req']) && in_array($_GET['xls_req'], $reports)) { header("Location: ".URL.$arr_docs[$_GET['xls_req']]); }else { header("Location: ".URL); }
}
else
{
	header('Location: 404');
}