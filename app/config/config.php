<?php

/*
|--------------------------------------------------------------------------
| Session start
|--------------------------------------------------------------------------
|
| Inicialización global de las sesiones + nombre de sesión principal del usuario
|
*/

session_start();

const USER_SESSION = 'session_user';

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
| URL
|--------------------------------------------------------------------------
|
| Establece la dirección específica del proyecto.
|
*/

const URL = 'http://localhost/skeleton/';

/*
|--------------------------------------------------------------------------
| Información de la aplicación
|--------------------------------------------------------------------------
|
| APP_NAME: Aparecerá en login, pestaña, correos y navbar.
| YEAR: Año de lanzamiento.
| MAIL: Encabezado de e-mail para el envío de correos de registro y restablecimiento de contraseña.
| VERSION: X: versión mayor | Y: versión menor | Z: revisión -> más info: https://ed.team/blog/como-se-deciden-las-versiones-del-software
| DEVOPS: Se establecen los nombres y correos de los integrantes del proyecto
|
*/

const APP_NAME 	= 'skeleton';
const YEAR 		= '2023';
const MAIL 		= 'no-reply@skeleton.dev';
const VERSION 	= 'x.y.z';
const DEVOPS 	= [
	'name' => ['Devop name'],
	'mail' => ['devop@mail.com']
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
| -----------------------
| DBMS        | Clave   |
| -----------------------
| MYSQL	      | MYSQL   |
| SQL SERVER  | SQLSRV  |
| ORACLE 	  | ORCL    |
| POSTGRESQL  | PGSQL   |
| UNIX SOCKET | SOCKET  |
| -----------------------
|
*/

const DBMS			= 'MYSQL';

const DB_SOCKET		= '';
const DB_HOST 		= 'localhost';
const DB_USER		= 'root';
const DB_PWD 		= '';
const DB_NAME 		= 'skeleton';
const DB_PORT 		= '';
const DB_CHARSET 	= 'utf8';


/*
|--------------------------------------------------------------------------
| Login params
|--------------------------------------------------------------------------
|
| Se establecen las constantes para inicios de sesión.
|
*/

const LC_LOGIN = true; //Local login
const LC_SIGNU = true; //Registro local
const FB_LOGIN = false; //Facebook login
const GL_LOGIN = false; //Google login
const MS_LOGIN = false; //Microsoft login
const TW_LOGIN = false; //Twitter login
const GH_LOGIN = false; //Github login


/*
|--------------------------------------------------------------------------
| reCAPTCHA
|--------------------------------------------------------------------------
|
| Establece la clave de seguridad de reCAPTCHA.
|
*/

const WEBKEY = '6Ld7NrgpAAAAACIokUnERwXs4qmJcN3S3KRWxUfd';

const SECRETKEY = '6Ld7NrgpAAAAAM96DxMUtNICLxdHC6hBQIhhwaDV';


/*
|--------------------------------------------------------------------------
| Mail params for PHP MAILER
|--------------------------------------------------------------------------
|
| Se establecen las constantes para envíos de correos.
|
*/

const MAIL_SMTP_SECURE = '';
const MAIL_HOST = '';
const MAIL_PORT = 0;
const MAIL_USERNAME = '';
const MAIL_PASSWORD = '';
const MAIL_ENCRYPTION = '';
const MAIL_FROM_ADDRESS = '';
const MAIL_FROM_NAME = 'no-reply@'.APP_NAME.'.com';

/*
|--------------------------------------------------------------------------
| Language params
|--------------------------------------------------------------------------
|
| Para agregar más idiomas debes crear el fichero de idioma en: app/config/languages
|
*/

function select_lang($lang)
{
	return 'app/config/languages/'.$lang.'.php';
}

/*
|--------------------------------------------------------------------------
| VIEWS LIST
|--------------------------------------------------------------------------
|
| Aquí se establecerá la lista de vistas permitidas de acuerdo al nivel de acceso
| que posee el usuario. Los arreglos se establecerán de acuerdo a los niveles
| de acceso que se hayan configurado en la base de datos.
|
| Nota: La vista Master será la única que se mantendrá siempre definida.
|
*/

const VIEWS_LIST = [
	'Master' => [
		'views' =>[
			'profile',
			'info',
			'support'
		],
		'titles' =>[
			'profile' => 'perfil de usuario',
			'info' => 'información del sistema',
			'support' => 'soporte técnico'
		]
	],

	'Super' => [
		'views' => [
			'sudo_starter',
			'users',
			'new_user',
			'user_profile',
			'tbl_countries',
			'tbl_languages',
			'tbl_actions',
			'tbl_logs',
			'support_request',
			'reports'
		],
		'titles' => [
			'users' => 'usuarios',
			'new_user' => 'nuevo usuario',
			'user_profile' => 'perfil de usuario',
			'tbl_countries' => 'tbl_countries',
			'tbl_languages' => 'tbl_languages',
			'tbl_levels' => 'tbl_levels',
			'tbl_logscron' => 'tbl_logscron',
			'tbl_records' => 'tbl_records',
			'tbl_profilepics' => 'tbl_profilepics',
			'tbl_status' => 'tbl_status',
			'tbl_welcome' => 'tbl_welcome',
			'support_request' => 'Solicitudes de soporte',
			'reports' => 'Reportes'
		]
	],

	'Admin' => [
		'views' => [
			'sudo_starter',
			'users',
			'new_user',
			'user_profile',
			'support_request',
			'reports'
		],
		'titles' => [
			'users' => 'usuarios',
			'new_user' => 'nuevo usuario',
			'user_profile' => 'perfil de usuario',
			'support_request' => 'Solicitudes de soporte',
			'reports' => 'Reportes'
		]
	],

	'Emp' => [
		'views' => [
			'emp_starter'
		],
		'titles' => [
		]
	]
];

/*
|--------------------------------------------------------------------------
| load_view
|--------------------------------------------------------------------------
|
| Carga la vista solicitada.
|
*/

function load_view($req = null, $val = null)
{
	if (is_null($req)) {
		$url = URL;
	}elseif (is_null($val)) {
		$url = URL.$req;
	}else {
		$url = URL.$req.'?val='.$val;
	}

	header("Location: {$url}");
}

/* Definimos la zona horaria */

date_default_timezone_set('America/El_Salvador');