<?php

require_once "../app/config/config.php";
require_once "../app/controllers/HomeController.php";
require_once "../app/controllers/{$_SESSION['session_appname']['level']}Controller.php";
require_once '../app/config/languages/'.$_SESSION['lang']['lancode'].'.php';


/*
|--------------------------------------------------------------------------
| Obtención de Sesion "Val" y/o "Cont"
|--------------------------------------------------------------------------
*/

if (isset($_POST['getvalviews'])) {
	$info = [];
	$info['val'] = (isset($_SESSION['val'])) ? $_SESSION['val'] : false;
	$info['cont'] = (isset($_SESSION['cont'])) ? $_SESSION['cont'] : false;
	echo json_encode($info);
}


/*
|--------------------------------------------------------------------------
| Pestañas de perfil personal
|--------------------------------------------------------------------------
|
| Recordatrorio de pestaña seleccionada
|
*/

if (isset($_POST['nowselecttab'])) {
	$_SESSION['tab_selected'] = $_POST['nowselecttab'];
	echo $_POST['nowselecttab'];
}

if (isset($_POST['selecttab'])) {
	$res = (isset($_SESSION['tab_selected'])) ? $_SESSION['tab_selected'] : 'info';
	echo $res;
}


/*
|--------------------------------------------------------------------------
| Acciones de alerta de bienvenida
|--------------------------------------------------------------------------
*/

if (isset($_POST['starter']))
{
	$user = $model->user_info($_SESSION['session_appname']['id']);

	$welcome = $model->info_welcome($_SESSION['session_appname']['id']);

	$data = ($welcome) ? array_merge($user, $welcome) : $user;

	$data['wcancel'] = (isset($_SESSION['welcome_cancel'])) ? 1 : 0;

	echo json_encode($data);
}


if (isset($_POST['welcome_finished']))
{
	echo json_encode($model->welcome_finished($_SESSION['session_appname']['id']));
}


if (isset($_POST['welcome_denied']))
{
	echo json_encode($model->welcome_denied($_SESSION['session_appname']['id']));
}


if (isset($_POST['welcome_cancel']))
{
	$_SESSION['welcome_cancel'] = true;
	echo json_encode(true);
}


/*
|--------------------------------------------------------------------------
| Registro de usuario
|--------------------------------------------------------------------------
|
| Comprobaciones de campos para el registro de un usuario
|
*/

if (isset($_POST['newuser']))
{
	$data['name'] = (isset($_POST['name'])) ? preg_replace('([^A-Za-zÁ-ź ])', '', trim($_POST['name'])) : null;
	$data['email'] = (isset($_POST['email'])) ? preg_replace('([^A-Za-z-_.@ ])', '', trim($_POST['email'])) : null;
	$email = (isset($_POST['email2'])) ? preg_replace('([^A-Za-z-_.@ ])', '', trim($_POST['email2'])) : null;
	$data['country'] = (isset($_POST['country'])) ? preg_replace('([^0-9])', '', trim($_POST['country'])) : null;
	$data['lang'] = (isset($_POST['lang'])) ? preg_replace('([^0-9])', '', trim($_POST['lang'])) : null;
	$data['level'] = (isset($_POST['level'])) ? preg_replace('([^0-9])', '', trim($_POST['level'])) : null;
	$data['pass'] = (isset($_POST['pass1']) && !empty($_POST['pass1'])) ? trim($_POST['pass1']) : null;
	$pass = (isset($_POST['pass2']) && !empty($_POST['pass2'])) ? trim($_POST['pass2']) : null;

	if (!in_array(null, $data)) {
		if ($data['email'] == $email && $data['pass'] == $pass) {
			$res = $model->new_user($data);
		}else {
			$res = false;
		}
	}else {
		$res = false;
	}

	echo json_encode($res);
}


/*
|--------------------------------------------------------------------------
| Actualización de datos
|--------------------------------------------------------------------------
*/

if (isset($_POST['welcomeform']))
{
	$data['name'] = (isset($_POST['name'])) ? preg_replace('([^A-Za-zÁ-ź ])', '', trim($_POST['name'])) : null;
	$data['country'] = (isset($_POST['country'])) ? preg_replace('([^0-9])', '', trim($_POST['country'])) : null;
	$data['lang'] = (isset($_POST['lang'])) ? preg_replace('([^0-9])', '', trim($_POST['lang'])) : null;
	$data['id'] = $_SESSION['session_appname']['id'];

	if (!in_array(null, $data)) {
		$res = $model->addwelcome($data);
		if ($res)
			unset($_SESSION['view']);
		else
			$res = false;
	}else {
		$res = false;
	}


	echo json_encode($res);
}


/*
|--------------------------------------------------------------------------
| Actualición de perfil de usuario
|--------------------------------------------------------------------------
|
| Edición de perfil de usuario
|
*/

if (isset($_POST['update_profile']))
{
	$data['name'] = (isset($_POST['name'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['name'])) : false;
	$data['lang'] = (isset($_POST['language'])) ? preg_replace('([^0-9 ])', '', trim($_POST['language'])) : false;
	$data['country'] = (isset($_POST['country'])) ? preg_replace('([^0-9 ])', '', trim($_POST['country'])) : false;
	$data['level'] = $_SESSION['session_appname']['idlvl'];
	$data['status'] = $_SESSION['session_appname']['idstatus'];
	$data['id'] = $_SESSION['session_appname']['id'];

	if (!in_array(false, $data)) {
		unset($_SESSION['updateInfoUser']);
		echo json_encode($model->update_user($data));
	}else {
		echo json_encode(false);
	}
}


/*
|--------------------------------------------------------------------------
| Actualición de perfil de usuario
|--------------------------------------------------------------------------
|
| Edición de perfil de usuario
|
*/

if (isset($_POST['update_user']))
{
	$data['name'] = (isset($_POST['name'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['name'])) : false;
	$data['country'] = (isset($_POST['country'])) ? preg_replace('([^0-9 ])', '', trim($_POST['country'])) : false;
	$data['lang'] = (isset($_POST['lang'])) ? preg_replace('([^0-9 ])', '', trim($_POST['lang'])) : false;
	$data['level'] = (isset($_POST['level'])) ? preg_replace('([^0-9 ])', '', trim($_POST['level'])) : false;
	$data['status'] = (isset($_POST['status'])) ? preg_replace('([^0-9 ])', '', trim($_POST['status'])) : false;
	$data['id'] = $_SESSION['val'];

	if (!in_array(false, $data)) {
		unset($_SESSION['updateInfoUser']);
		echo json_encode($model->update_user($data));
	}else {
		echo json_encode(false);
	}
}


/*
|--------------------------------------------------------------------------
| Update PicProfile
|--------------------------------------------------------------------------
|
| Actualización de imagen de perfil
|
*/

if (isset($_POST['picprofile']))
	echo $model->update_pic_profile($_POST['id']);


/*
|--------------------------------------------------------------------------
| Actualización de contraseña
|--------------------------------------------------------------------------
|
| Comprobacion y actualización de contraseña
|
*/

if (isset($_POST['validate_pass']))
{
	echo json_encode($model->pass_validator($_POST['curpass'], $_SESSION['session_appname']['id']));
}

if (isset($_POST['updtpwd']))
{
	if (isset($_SESSION['val'])) {
		$res = $objHome->updatePass($_SESSION['val'], $_POST['pass1'], $_POST['pass2']);
	}else {
		$res = $objHome->updatePass($_SESSION['session_appname']['id'], $_POST['pass1'], $_POST['pass2'], $_POST['curpass']);
	}

	echo json_encode($res);
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
	$frase = $sudo_c->userDeletePhrase($_SESSION['val']);
	echo (trim($_POST['phrase']) == $frase) ? json_encode(true) : json_encode(false);
}

if (isset($_POST['deluser'])) { echo json_encode($sudo_c->userdel(trim($_POST['phrase']), $_SESSION['val'])); }


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
	if (!empty($subject) && !empty($mssg)) {
		echo json_encode($model->new_support_request($subject, $mssg, $_SESSION['session_appname']['id']));
	}else {
		echo json_encode(false);
	}
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
	if (!empty($response))
		echo json_encode($sudo_m->savesupportres($id, $response));
	else
		echo json_encode(false);
}


/*
|--------------------------------------------------------------------------
| C R U D -> tbl_users
|--------------------------------------------------------------------------
*/

if (isset($_POST['crud_users']))
{
	$option = (isset($_POST['option'])) ? preg_replace('([^a-z])', '', trim( strtolower($_POST['option']) )) : false;

	switch ($option)
	{
		case 'read':
			echo json_encode($model->datatable('v_users','iduser', [ '*' ]));
		break;

		default:
			return false;
		break;
	}
}


/*
|--------------------------------------------------------------------------
| C R U D -> tbl_countries
|--------------------------------------------------------------------------
*/

if (isset($_POST['crud_country']))
{
	$option = (isset($_POST['option'])) ? preg_replace('([^a-z])', '', trim( strtolower($_POST['option']) )) : false;

	switch ($option)
	{
		case 'create':
			$data['country'] = (isset($_POST['country'])) ? preg_replace('([^A-Za-zÁ-ź ])', '', trim($_POST['country'])) : null;
			$data['badge'] = (isset($_POST['badge'])) ? preg_replace('([^A-Za-zÁ-ź ])', '', trim($_POST['badge'])) : null;
			$data['isocode'] = (isset($_POST['isocode'])) ? preg_replace('([^A-Z ])', '', trim( strtoupper( $_POST['isocode'] ))) : null;

			echo (!in_array(null, $data)) ? json_encode($model->new_country($data)) : json_encode(false);
		break;

		case 'read':
			echo json_encode($model->datatable('v_countries','idcountry', [ '*' ]));
		break;

		case 'update':
			$data['country'] = (isset($_POST['country'])) ? preg_replace('([^A-Za-zÁ-ź ])', '', trim($_POST['country'])) : null;
			$data['badge'] = (isset($_POST['badge'])) ? preg_replace('([^A-Za-zÁ-ź ])', '', trim($_POST['badge'])) : null;
			$data['isocode'] = (isset($_POST['isocode'])) ? trim($_POST['isocode']) : null;
			$data['id'] = (isset($_POST['idcountry'])) ? preg_replace('([^0-9])', '', trim($_POST['idcountry'])) : null;

			echo (!in_array(null, $data)) ? json_encode($model->edit_country($data)) : json_encode(false);
		break;

		case 'change':
			$data['id'] = (isset($_POST['idcountry'])) ? preg_replace('([^0-9])', '', trim($_POST['idcountry'])) : null;

			echo (!is_null($data['id'])) ? json_encode($model->ch_countries_status($data)) : json_encode(false);
		break;

		case 'delete':
			$data['id'] = (isset($_POST['idcountry'])) ? preg_replace('([^0-9])', '', trim($_POST['idcountry'])) : null;

			echo (!is_null($data['id'])) ? json_encode($model->delete_country($data)) : json_encode(false);
		break;

		default:
			return false;
		break;
	}
}

if (isset($_POST['infocountries']))
{
	$country = $model->countries_list();

	$i = array_search($_POST['id'], $country['idcountry']);

	$data = [
		'idcountry' => $country['idcountry'][$i],
		'country' => $country['country'][$i],
		'badge' => $country['badge'][$i],
		'isocode' => $country['isocode'][$i],
		'idstatus' => $country['idstatus'][$i],
		'status' => $country['status'][$i]
	];

	echo json_encode($data);
}


/*
|--------------------------------------------------------------------------
| C R U D -> tbl_languages
|--------------------------------------------------------------------------
*/

if (isset($_POST['crud_language']))
{
	$option = (isset($_POST['option'])) ? preg_replace('([^a-z])', '', trim( strtolower($_POST['option']) )) : false;

	switch ($option)
	{
		case 'create':
			$data['language'] = (isset($_POST['language'])) ? preg_replace('([^A-Za-zÁ-ź ])', '', trim($_POST['language'])) : null;
			$data['lancode'] = (isset($_POST['lancode'])) ? preg_replace('([^A-Za-zÁ-ź ])', '', trim($_POST['lancode'])) : null;

			echo (!in_array(null, $data)) ? json_encode($model->new_language($data)) : json_encode(false);
		break;

		case 'read':
			echo json_encode($model->datatable('v_languages','idlang', [ '*' ]));
		break;

		case 'update':
			$data['language'] = (isset($_POST['language'])) ? preg_replace('([^A-Za-zÁ-ź ])', '', trim($_POST['language'])) : null;
			$data['lancode'] = (isset($_POST['lancode'])) ? preg_replace('([^A-Za-zÁ-ź ])', '', trim($_POST['lancode'])) : null;
			$data['id'] = (isset($_POST['idlang'])) ? preg_replace('([^0-9])', '', trim($_POST['idlang'])) : null;

			echo (!in_array(null, $data)) ? json_encode($model->edit_language($data)) : json_encode(false);
		break;

		case 'change':
			$data['id'] = (isset($_POST['idlang'])) ? preg_replace('([^0-9])', '', trim($_POST['idlang'])) : null;

			echo (!is_null($data['id'])) ? json_encode($model->ch_language_status($data)) : json_encode(false);
		break;

		case 'delete':
			$data['id'] = (isset($_POST['idlang'])) ? preg_replace('([^0-9])', '', trim($_POST['idlang'])) : null;

			echo (!is_null($data['id'])) ? json_encode($model->delete_language($data)) : json_encode(false);
		break;

		default:
			return false;
		break;
	}
}

if (isset($_POST['infolanguage']))
{
	$language = $model->language_list();

	$i = array_search($_POST['id'], $language['idlang']);

	$data = [
		'idlang' => $language['idlang'][$i],
		'language' => $language['language'][$i],
		'lancode' => $language['lancode'][$i],
		'lanicon' => $language['lanicon'][$i],
		'idstatus' => $language['idstatus'][$i],
		'status' => $language['status'][$i]
	];

	echo json_encode($data);
}


// ************************************************************************************
// ************************************************************************************