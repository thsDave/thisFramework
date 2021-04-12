<?php

require_once 'config/config.php';

require_once 'controllers/Controller.php';

if (!empty($_SESSION))
{
	if (isset($_SESSION['log']))
	{
		require_once 'controllers/HomeController.php';

		$location = APP.'/views/'.$_SESSION['log']['level'].'/';

		$class = $_SESSION['log']['level']."Controller";
		$userController = "app/controllers/{$class}.php";

		require_once $userController;

		if (isset($_SESSION['view']))
		{
			$master = ["profile", "support", "info"];

			if (in_array($_SESSION['view'], $master))
				$location = APP.'/views/master/'.$_SESSION['view'].'.php';
			else
				$location = $location.$_SESSION['view'].'.php';

			try
			{
				if (file_exists($location)) require_once $location; else throw new Exception('404');
			}
			catch (Exception $e)
			{
				load_view('404');
			}
		}
		else
		{
			require_once $location.'starter.php';
		}
	}
	else if (isset($_SESSION['gestion']))
	{
		switch ($_SESSION['gestion'])
		{
			case 'login': require_once 'views/starter/login.php'; break;

			case 'register': require_once 'views/starter/register.php'; break;

			case 'forget': require_once 'views/starter/forgot-password.php'; break;

			case 'reset': require_once 'views/starter/reset.php'; break;
		}
	}
	else
	{
		require_once 'views/starter/login.php';
	}
}
else
{
	require_once 'views/starter/login.php';
}