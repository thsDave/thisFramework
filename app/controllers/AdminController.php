<?php

require_once APP.'/models/Admin.php';

class AdminController extends Admin
{

}

$administrator_m = new Admin;

$administrator_c = new AdminController;

if (isset($_GET['event']))
{
	$method_name = $_GET['event'];
	$val = (isset($_GET['val'])) ? $_GET['val']:null;

	if (method_exists($administrator_c, $method_name))
	{
		if (is_null($val))
			$administrator_c->$method_name();
		else
			$administrator_c->$method_name($val);
	}
	if (method_exists($objHome, $method_name))
	{
		if (is_null($val))
			$objHome->$method_name();
		else
			$objHome->$method_name($val);
	}
	else
	{
		load_view('404');
	}
}