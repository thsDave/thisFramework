<?php

require_once 'config/config.php';

require_once 'controllers/Controller.php';

if (!empty($_SESSION))
{
	if (isset($_SESSION[USER_SESSION]))
	{
		require_once select_lang($_SESSION['lang']['lancode']);

		require_once 'controllers/HomeController.php';

		$class = $_SESSION[USER_SESSION]['level']."Controller";

		$userController = "app/controllers/{$class}.php";

		require_once $userController;

		if (isset($_SESSION['view']))
		{
			try
			{
				$levels = $model->level_list();

				if (in_array($_SESSION[USER_SESSION]['level'], $levels['level']))
				{
					if (in_array($_SESSION['view'], VIEWS_LIST[$_SESSION[USER_SESSION]['level']]['views']))
					{
						$_SESSION['title'] = $_SESSION[USER_SESSION]['level'];
						$location = APP.'/views/pool/'.$_SESSION['view'].'.php';
					}
					else if (in_array($_SESSION['view'], VIEWS_LIST['Master']['views']))
					{
						$_SESSION['title'] = 'Master';
						$location = APP.'/views/master/'.$_SESSION['view'].'.php';
					}
					else
					{
						throw new Exception('404');
					}
				}
				else
				{
					throw new Exception('404');
				}

				if (file_exists($location)) require_once $location; else throw new Exception('404');
			}
			catch (Exception $e)
			{
				load_view('404');
			}
		}
		else
		{
			try
			{
				$starter = strtolower($_SESSION[USER_SESSION]['level']).'_starter.php';

				$location = APP.'/views/pool/'.$starter;

				if (file_exists($location)) require_once $location; else throw new Exception('404');
			}
			catch (Exception $e)
			{
				load_view('404');
			}
		}
	}
	else if (isset($_SESSION['gestion']))
	{
		switch ($_SESSION['gestion'])
		{
			case 'login': require_once 'views/starter/login.php'; break;

			case 'register': require_once 'views/starter/register.php'; break;

			case 'confirm': require_once 'views/starter/reset.php'; break;

			case 'cancel': require_once 'views/starter/cancel.php'; break;

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