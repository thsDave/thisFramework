<?php

require_once "../app/config/config.php";
require_once "../app/controllers/Controller.php";


/*
|--------------------------------------------------------------------------
| Login with Firebase
|--------------------------------------------------------------------------
|
| Login de usuarios con firebase
|
*/


if (isset($_POST['localogin']))
{
	if (isset($_POST['remember'])) {
		$res = $objController->login($_POST['user'], 'local', $_POST['pwd'], $_POST['remember']);
	}else {
		$res = $objController->login($_POST['user'], 'local', $_POST['pwd']);
	}
	echo $res;
}


/*
|--------------------------------------------------------------------------
| Login with Firebase
|--------------------------------------------------------------------------
|
| Login de usuarios con firebase
|
*/


if (isset($_POST['firelogin'])) {
	$objController->login($_POST['email'], 'social');
}


/*
|--------------------------------------------------------------------------
| Register with Firebase
|--------------------------------------------------------------------------
|
| Registro de usuarios con firebase
|
*/

if (isset($_POST['fireregister']))
{
	$name = (isset($_POST['name'])) ? $_POST['name'] : 'Name empty';
	$email = (isset($_POST['email'])) ? $_POST['email'] : false;

	echo $objController->newregister($name, $email, 'Empty', 'social');
}

/*
|--------------------------------------------------------------------------
| Registro de usuario
|--------------------------------------------------------------------------
|
| Comprobaciones de campos en registro local de usuario
|
*/

if (isset($_POST['register']))
{
	function validarstring($string)
	{
		$abc = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyzáéíóúÁÉÍÓÚ ';
		$abc = str_split($abc);
		$string = str_split($string);
		foreach ($string as $value) { if (in_array($value, $abc)) { $res = true; }else { $res = false; break; } }
		return $res;
	}

	function validarmail($email)
	{
		$mail_array = 'abcdefghijklmnñopqrstuvwxyz1234567890_.-@';
		$mail_array = str_split($mail_array);
		$mail = str_split($email);
		foreach ($mail as $value) { if (in_array($value, $mail_array)) { $res = true; }else { $res = false; break; } }
		if ($res) {
			$arroba = strpos($email, '@');
			if (!empty($arroba)) {
				$dominio = substr($email, $arroba);
				$punto = strrpos($dominio, '.');
				$res = (!empty($punto)) ? true : false;
			}else {
				$res = false;
			}
		}
		return $res;
	}

	if (isset($_POST['name'])) {
		$res = validarstring(trim($_POST['name']));
		$_SESSION['register']['name'] = ($res) ? trim($_POST['name']) : false;
	}

	if (isset($_POST['position'])) {
		$string = (!empty($_POST['position'])) ? trim($_POST['position']) : 'Empty';
		$res = validarstring(trim($_POST['position']));
		$_SESSION['register']['position'] = ($res) ? trim($_POST['position']) : 'Empty';
	}else{
		$_SESSION['register']['position'] = 'Empty';
	}

	if (isset($_POST['email'])) {
		$res = validarmail(strtolower(trim($_POST['email'])));
		$_SESSION['register']['email'] = ($res) ? strtolower(trim($_POST['email'])) : false;
	}

	if (isset($_POST['email2'])) {
		$res = validarmail(strtolower(trim($_POST['email2'])));
		$_SESSION['register']['email2'] = ($res) ? strtolower(trim($_POST['email2'])) : false;
	}

	echo $res;
}

if (isset($_POST['newregister']))
{
	if (isset($_SESSION['register']))
	{
		if (in_array(false, $_SESSION['register'])) {
			echo false;
		}else {
			$name = (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : false;
			$position = (isset($_POST['position']) && !empty($_POST['position'])) ? $_POST['position'] : 'Empty';
			$email = (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : false;
			$email2 = (isset($_POST['email2']) && !empty($_POST['email2'])) ? $_POST['email2'] : false;

			if ($email == $email2) {
				if ($name && $position && $email && $email2) {
					echo $objController->newregister($name, $email, $position);
				}else {
					echo false;
				}
			}else {
				echo false;
			}
		}
	}
	else
	{
		echo false;
	}
}


/*
|--------------------------------------------------------------------------
| Restablecer contraseña de usuario
|--------------------------------------------------------------------------
|
| Ingreso de nueva contraseña
|
*/


if (isset($_POST['restorepwd']))
{
	if (strlen($_POST['pass1']) >= 8 && strlen($_POST['pass2']) >= 8) {
		if ($_POST['pass1'] == $_POST['pass2']) {
			echo $objController->resetPassword($_POST['pass1']);
		}else {
			echo false;
		}
	}else {
		echo false;
	}
}