<?php

require_once APP.'/models/Super.php';

class SuperController extends Super
{
	public function getmailusr($email)
	{
		$arr = str_split($email);
		$user = '';
		foreach ($arr as $value) {
			if ($value == '@') {
				break;
			}else {
				$user .= $value;
			}
		}
		return $user;
	}

	public function userDeletePhrase($iduser)
	{
		$user = parent::user_info($iduser);
		$email = $user['email'];
		$arr = str_split($email);
		$user = '';
		foreach ($arr as $value) { if ($value == '@') { break; } else { $user .= $value; } }
		$phrase = "inactive.{$user}";
		return $phrase;
	}

	public function userdel($frase, $iduser)
	{
		$phrase = $this->userDeletePhrase($iduser);

		if ($frase == $phrase)
			return parent::deleteuser($iduser);
		else
			return false;
	}
}

$sudo_m = new Super;

$sudo_c = new SuperController;

if (isset($_GET['event']))
{
	$method_name = $_GET['event'];
	$val = (isset($_GET['val'])) ? $_GET['val'] : null;
	if (method_exists($sudo_c, $method_name)) {
		if (is_null($val))
			$sudo_c->$method_name();
		else
			$sudo_c->$method_name($val);
	}else if (method_exists($objHome, $method_name)) {
		if (is_null($val))
			$objHome->$method_name();
		else
			$objHome->$method_name($val);
	}else{
		load_view('404');
	}
}