<?php

require_once "../app/config/config.php";
require_once "../app/controllers/Controller.php";

/*
|--------------------------------------------------------------------------
| Local login
|--------------------------------------------------------------------------
|
| Inicio de sesión usando formulario de login
|
*/


if (isset($_POST['localogin']))
{
	echo json_encode($objController->login($_POST['user'], 'local', $_POST['pwd']));
}


/*
|--------------------------------------------------------------------------
| Login with Firebase
|--------------------------------------------------------------------------
|
| Login de usuarios con firebase
|
*/


if (isset($_POST['firelogin']))
{
	if ($objController->login($_POST['email'], 'social'))
	{
		echo json_encode(true);
	}
	else
	{
		$name = (isset($_POST['name'])) ? $_POST['name'] : 'Name empty';
		$email = (isset($_POST['email'])) ? $_POST['email'] : false;
		$position = (isset($_POST['position'])) ? $_POST['position'] : 'No registered position';

		if ($objController->newregister($name, $email, $position, 1, 1, 2, 'social'))
			echo json_encode($objController->login($email, 'social'));
		else
			echo json_encode(false);
	}
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

	echo json_encode($objController->newregister($name, $email, 'No registered position', 1, 1, 3, 'social'));
}

/*
|--------------------------------------------------------------------------
| Registro de usuario
|--------------------------------------------------------------------------
|
| Comprobaciones de campos en registro local de usuario
|
*/

if (isset($_POST['newregister']))
{
	$data['name'] = (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : false;
	$data['lang'] = (isset($_POST['lang']) && !empty($_POST['lang'])) ? $_POST['lang'] : false;
	$data['country'] = (isset($_POST['country']) && !empty($_POST['country'])) ? $_POST['country'] : false;
	$data['email'] = (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : false;
	$data['email2'] = (isset($_POST['email2']) && !empty($_POST['email2'])) ? $_POST['email2'] : false;

	if (!in_array(false, $data))
	{
		if ($data['email'] == $data['email2'])
			$res = $objController->newregister($data);
		else
			$res = false;
	}
	else
	{
		$res = false;
	}

	echo json_encode($res);
}

/*
|--------------------------------------------------------------------------
| Activación de restablecimiento de contraseña
|--------------------------------------------------------------------------
|
| Ingreso de nueva contraseña
|
*/

if (isset($_POST['forgot-email']))
{
	echo json_encode($objController->send_resetpass($_POST['mail']));
}


/*
|--------------------------------------------------------------------------
| Restablecer contraseña de usuario
|--------------------------------------------------------------------------
|
| Ingreso de nueva contraseña
|
*/

if (isset($_POST['getusrinfo']))
{
	$res = (isset($_SESSION['token'])) ? $model->user_info_by_token($_SESSION['token']) : false;

	echo json_encode($res);
}

if (isset($_POST['restorepwd']))
{
	if ( strlen( trim( $_POST['pass1'] ) ) >= 8 && strlen( trim( $_POST['pass2'] ) ) >= 8 ) {
		if ($_POST['pass1'] === $_POST['pass2']) {
			echo json_encode($objController->resetPassword($_POST['pass1']));
		}else {
			echo json_encode(false);
		}
	}else {
		echo json_encode(false);
	}
}

/*
|--------------------------------------------------------------------------
| Reporte de problemas con base de datos
|--------------------------------------------------------------------------
*/

if (isset($_POST['err_db_mnsj']))
{
	$html = '
	<!DOCTYPE html>
		<html lang="es-SV">
			<head>
				<meta charset="utf-8">
				<title>educo</title>
				<style>
				html {
					font-family: sans-serif;
					line-height: 1.15;
					-webkit-text-size-adjust: 100%;
					-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
				}
				h1, h2, h3, h4, h5, h6 {
				  margin-top: 0;
				  margin-bottom: 0.5rem;
				}
				p{
					font-size: 16px !important;
				}
				a{
					font-size: 16px !important;
				}
				</style>
			</head>
			<body>
				<div style="width: 9% !important;">
					<img src="'.URL.'dist/img/logo-mail.png" style="width: 100% !important;" alt="logo">
				</div>
				<h1 style="font-size: 30px !important;">'.APP_NAME.'</h1>
				<h3 style="font-size: 20px !important;">Notificación de error</h3>
				<p style="margin-top: 30px;">Hola,</p>
				<p style="margin-top: 30px;">Este es un mensaje automático, informando sobre errores de conexión a bases de datos fleetsys.</p>
				<p style="margin-top: 30px;">
					Gracias por confiar en nosotros.
				</p>
				<p style="margin-top: 30px;">Atentamente:</p>
				<p style="margin-top: 10px;">
					<strong>Administrador fleetsys</strong>
				</p>
				<hr style="margin-top: 30px;">
				<p>Este es un mensaje automático enviado desde nuestro sistema de control de flota vehicular, por favor no respondas a este correo.</p>
			</body>
		</html>
	';

	$headers = "MIME-Version: 1.0"."\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";

	$headers .= "From: fleetsys@educo.org"."\r\n";

	$res = (mail('isaac.ramos@educo.org', 'Fleetsys | db_err', $html, $headers)) ? true: false;

	echo json_encode($res);
}