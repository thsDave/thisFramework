<?php

require_once APP.'/models/Emp.php';

class EmpController extends Emp
{

}

$employee_m = new Emp;

$employee_c = new EmpController;

if (isset($_GET['event']))
{
	$method_name = $_GET['event'];
	$val = (isset($_GET['val'])) ? $_GET['val']:null;

	if (method_exists($employee_c, $method_name))
	{
		if (is_null($val))
			$employee_c->$method_name();
		else
			$employee_c->$method_name($val);
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