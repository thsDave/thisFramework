<?php

require_once APP.'/models/Employee.php';

class EmployeeController extends Employee
{

}

$employee_m = new Employee;

$employee_c = new EmployeeController;

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