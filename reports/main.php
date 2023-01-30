<?php

require_once "../../app/config/config.php";
require_once "../../app/controllers/Controller.php";
require_once "../../app/controllers/HomeController.php";
require_once "../../app/controllers/{$_SESSION['session_appname']['level']}Controller.php";
require_once "../../app/config/languages/{$_SESSION['lang']['lancode']}.php";