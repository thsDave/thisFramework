<?php

require_once "../app/config/config.php";
require_once "../app/controllers/HomeController.php";
require_once "../app/controllers/{$_SESSION['log']['level']}Controller.php";

/*
|--------------------------------------------------------------------------
| Actualización de perfil personal
|--------------------------------------------------------------------------
|
| Edición de perfil de usuario personal
|
*/


if (isset($_POST['updtUser']))
{
	$name = (isset($_POST['name'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['name'])) : null;
	$position = (isset($_POST['position'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['position'])) : null;

	$_SESSION['log']['name'] = (!is_null($name)) ? $name : $_SESSION['log']['name'];
	$_SESSION['log']['position'] = (!is_null($position)) ? $position : $_SESSION['log']['position'];

	echo ($objHome->updtUser()) ? true : false;
}


/*
|--------------------------------------------------------------------------
| Actualición de perfile de usuarios
|--------------------------------------------------------------------------
|
| Edición de perfil de usuario personal
|
*/


if (isset($_POST['updtinfousr']))
{
	$name = (isset($_POST['name'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['name'])) : null;
	$position = (isset($_POST['position'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['position'])) : null;
	$level = (isset($_POST['level'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['level'])) : null;
	$state = (isset($_POST['state'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['state'])) : null;

	echo $sudo_c->updtusr($name, $position, $level, $state);
}


/*
|--------------------------------------------------------------------------
| Update PicProfile
|--------------------------------------------------------------------------
|
| Actualización de imagen de perfil
|
*/

if (isset($_POST['picprofile'])) {
	echo $objHome->updtPic($_POST['id']);
}

/*
|--------------------------------------------------------------------------
| Actualización de contraseña
|--------------------------------------------------------------------------
|
| Comprobacion y actualización de contraseña
|
*/


if (isset($_POST['updtpwd']))
{
	$iduser = (isset($_SESSION['val'])) ? $_SESSION['val'] : $_SESSION['log']['id'];
	if (isset($_POST['currentPass']))
		$res = $objHome->updatePass($_POST['currentPass'], $_POST['pass1'], $_POST['pass2'], $iduser);
	else
		$res = $objHome->updatePass(null, $_POST['pass1'], $_POST['pass2'], $iduser);
	echo $res;
}


/*
|--------------------------------------------------------------------------
| Validación de eliminación
|--------------------------------------------------------------------------
|
| Comprobaciones de campos en registro local de usuario
|
*/


if (isset($_POST['valphrase']))
{
	$user = $model->infoUsuario($_SESSION['val']);
	$email = $user['email'];
	$arr = str_split($email);
	$user = '';
	foreach ($arr as $value) { if ($value == '@') { break; } else { $user .= $value; } }
	$frase = "delete.{$user}";
	echo ($_POST['phrase'] == $frase) ? true : false;
}

if (isset($_POST['deluser'])) { echo $sudo_c->userdel(); }


/*
|--------------------------------------------------------------------------
| Comentarios del sistema
|--------------------------------------------------------------------------
|
| Control de comentarios al sistema
|
*/


if (isset($_POST['newComment']))
{
	$model->insertComment(preg_replace('([^A-Za-zÁ-ź0-9-.¡!:\) ])', '', trim($_POST['comment'])), $_SESSION['log']['id']);

	load_view();
}

if (isset($_GET['delComment']))
{
	$model->delComment(preg_replace('([^A-Za-z0-9- ])', '', trim($_GET['delComment'])), $_SESSION['log']['id']);

	load_view();
}


/*
|--------------------------------------------------------------------------
| Soporte técnico (Cliente)
|--------------------------------------------------------------------------
|
| Obtener Solicitud de soporte técnico
|
*/


if (isset($_POST['newreqsupport'])) {
	$subject = preg_replace('([^A-Za-zÁ-ź0-9-.¡!:\) ])', '', trim($_POST['subject']));
	$mssg = preg_replace('([^A-Za-zÁ-ź0-9-.¡!:\) ])', '', trim($_POST['mssg']));
	echo $model->newreqsupport($subject, $mssg, $_SESSION['log']['id']);
}


/*
|--------------------------------------------------------------------------
| Soporte técnico (Sudo)
|--------------------------------------------------------------------------
|
| Obtener Solicitud de soporte técnico
|
*/


if (isset($_POST['getsupportreq'])) {
	$info = $sudo_m->getsupportreq($_POST['id']);
	echo json_encode($info);
}


if (isset($_POST['savesupportres'])) {
	$id = $_POST['id'];
	$response = preg_replace('([^A-Za-zÁ-ź0-9-.¡!:\) ])', '', trim($_POST['response']));
	echo $sudo_m->savesupportres($id, $response);
}