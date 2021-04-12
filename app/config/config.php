<?php

/*
|--------------------------------------------------------------------------
| Session start
|--------------------------------------------------------------------------
|
| Inicialización global de las sesiones
|
*/

session_start();

/*
|--------------------------------------------------------------------------
| URL
|--------------------------------------------------------------------------
|
| Establece la dirección específica del proyecto.
|
*/

const URL = 'http://localhost/thisframework/';

/*
|--------------------------------------------------------------------------
| Información de la aplicación
|--------------------------------------------------------------------------
|
| Establece el nombre público del proyecto
|
*/

const APP_NAME = 'thisFramework'; #Aparecerá en login, pestaña, correos y navbar
const YEAR = '2021';
const VERSION = '1.0.0';
const DEVOPS = [
	'name' => ['your name'],
	'mail' => ['your@email.com']
];

/*
|--------------------------------------------------------------------------
| Connection params
|--------------------------------------------------------------------------
|
| Se establecen las constantes a utilizar en la clase conexión,
| estas constantes pueden ser utilizadas para otras conexiones
| dentro del framework.
|
*/

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PWD = '';
const DB_NAME = 'db_thisframework';

/*
|--------------------------------------------------------------------------
| Mail params
|--------------------------------------------------------------------------
|
| Se establecen las constantes para envíos de correos.
|
*/

const MAIL_SMTP_SECURE = '';
const MAIL_HOST = '';
const MAIL_PORT = 000;
const MAIL_USERNAME = '';
const MAIL_PASSWORD = '';
const MAIL_ENCRYPTION = '';
const MAIL_FROM_ADDRESS = '';
const MAIL_FROM_NAME = 'no-reply@'.APP_NAME.'.com';

/*
|--------------------------------------------------------------------------
| Login params
|--------------------------------------------------------------------------
|
| Se establecen las constantes para inicios de sesión.
|
*/

const LC_LOGIN = true; //Local login
const FB_LOGIN = false; //Facebook login
const GL_LOGIN = false; //Google login
const MS_LOGIN = false; //Microsoft login
const TW_LOGIN = false; //Twitter login
const GH_LOGIN = false; //Github login

/*
|--------------------------------------------------------------------------
| APP DIR
|--------------------------------------------------------------------------
|
| APP permite obtener una ruta de acceso absoluta sin depender
| que el directorio de trabajo sea el directorio en el que reside.
|
*/

define('APP', dirname(dirname(__FILE__)));

/*
|--------------------------------------------------------------------------
| load_view
|--------------------------------------------------------------------------
|
| Carga la vista solicitada.
|
*/

function load_view($req = null)
{
	if (is_null($req))
		header("Location:".URL);
	else
		header("Location:".URL.$req);
}