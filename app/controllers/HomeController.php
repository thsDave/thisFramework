<?php

require_once 'Controller.php';

class HomeController extends Controller
{
	public function reqviews($req, $val = null, $cont = null, $status = null)
	{
		$_SESSION['view'] = $req;

		if (is_null($val))
			unset($_SESSION['val']);
		else
			$_SESSION['val'] = $val;

		if (is_null($cont))
			unset($_SESSION['cont']);
		else
			$_SESSION['cont'] = $cont;

		if (is_null($status))
			unset($_SESSION['status']);
		else
			$_SESSION['status'] = $status;

		switch ($req)
		{
			case 'home':
				unset($_SESSION['view']);
				unset($_SESSION['title']);
			break;

			case 'logout':
				parent::outputs($_SESSION['session_appname']['id']);
				session_destroy();
			break;
		}

		load_view();
	}

	public function updatePass($iduser, $pass1, $pass2, $current_pass = null)
	{
		$validation = (!is_null($current_pass)) ? parent::pass_validator($current_pass, $iduser) : true;

		if ($validation) {
			if (strlen($pass1) >= 8 && strlen($pass2) >= 8) {
				if ($pass1 == $pass2) {
					$arr_pass = str_split($pass1);
					$banco = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789abcdefghijklmnñopqrstuvwxyz_.@';
					$arr_banco = str_split($banco);

					$x = true;

					foreach ($arr_pass as $valor_pass) { if (!in_array($valor_pass, $arr_banco)) { $x = false; break; } }

					if ($x) {

						$arr_data = [
				            'pass' => password_hash($pass1, PASSWORD_DEFAULT, ['cost' => 12]),
				            'iduser' => $iduser
				        ];

						return (parent::update_password($arr_data)) ? true : false;
					}else {
						return false;
					}
				}else {
					return false;
				}
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	public function historysupportreq($iduser)
	{
		$body = "";
		$list = parent::history_request($iduser);
		if ($list) {
			foreach ($list['subject'] as $index => $value) {
				$class = ($list['idstatus'][$index] == 3) ? 'badge-warning' : 'badge-success';
				$body .= "
				<div class='card-body p-0'>
					<div class='mailbox-read-info'>
						<div class='row'>
							<div class='col-8'>
								<h5>". LANG['support_subject'].": {$value}</h5>
								<h6 class='mt-2'>From: {$_SESSION['session_appname']['email']}</h6>
							</div>
							<div class='col-4'>
								<span class='badge {$class} float-right'>{$list['status'][$index]}</span>
							</div>
						</div>
					</div>
					<div class='mailbox-read-message'>
						<p><strong>".LANG['support_mnsj'].":</strong></p>
						<p>{$list['mssg'][$index]}</p>
						<hr>
						<p><strong>".LANG['support_answer'].":</strong></p>
						<p>{$list['response'][$index]}</p>
					</div>
				</div>
				<div class='card-footer bg-dark'></div>
				";
			}
		}

		return $body;
	}

	public function menu_active_class($view)
	{
		return (isset($_SESSION['view'])) ? ($_SESSION['view'] == $view) ? 'active' : '' : '';
	}

	public function menu_treeview_class()
	{
		if (isset($_SESSION['view']))
		{
			$views = func_get_args();
			$class = '';
			foreach ($views as $view) {
				if ($_SESSION['view'] == $view) {
					$class = 'menu-open';
					break;
				}
			}
			return $class;
		}
		else
		{
			return '';
		}
	}

	public function title()
	{
		return
		(isset($_SESSION['view'])) ?
			(isset(VIEWS_LIST[$_SESSION['title']]['titles'][$_SESSION['view']])) ?
				APP_NAME.' - '.VIEWS_LIST[$_SESSION['title']]['titles'][$_SESSION['view']] : APP_NAME : APP_NAME.' - Inicio';
	}

	public function upInfo($val)
	{
		if ($val === 'on')
			$_SESSION['updateInfoUser'] = true;
		else
			unset($_SESSION['updateInfoUser']);

		load_view();
	}

	public function logout()
	{
		parent::pst("INSERT INTO tbl_outputs(iduser) VALUES (:iduser)", ['iduser' => $_SESSION['session_appname']['id']], false);
		session_destroy();
		load_view();
	}
}

$objHome = new HomeController;

if (isset($_GET['req']))
{
	if (isset($_GET['val']) && isset($_GET['cont']) && isset($_GET['status']))
	{
		$objHome->reqviews($_GET['req'], $_GET['val'], $_GET['cont'], $_GET['status']);
	}
	else if (isset($_GET['val']) && isset($_GET['cont']))
	{
		$objHome->reqviews($_GET['req'], $_GET['val'], $_GET['cont']);
	}
	else if (isset($_GET['val']) && isset($_GET['status']))
	{
		$objHome->reqviews($_GET['req'], $_GET['val'], null, $_GET['status']);
	}
	else if (isset($_GET['val']))
	{
		$objHome->reqviews($_GET['req'], $_GET['val']);
	}
	else
	{
		$objHome->reqviews($_GET['req']);
	}
}