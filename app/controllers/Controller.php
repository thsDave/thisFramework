<?php

require_once APP.'/models/Model.php';

class Controller extends Model
{
	public function actions($action, $value = '')
	{
		switch ($action)
		{
			case 'forgot':
				$_SESSION['gestion'] = 'forget';
			break;

			case 'register':
				$_SESSION['gestion'] = 'register';
			break;

			case 'reset':
				if (strlen($value) == 50)
				{
					if (parent::validarToken($value))
					{
						$_SESSION['gestion'] = 'reset';
						$_SESSION['token'] = $value;
					}
					else
					{
						session_destroy();
					}
				}
			break;

			case 'delRegister':
				if (strlen($value) == 50)
				{
					if (parent::validarToken($value))
					{
						parent::delRegister($value);
						session_destroy();
					}
					else
					{
						session_destroy();
					}
				}
			break;

			case 'login':
				session_destroy();
			break;

			case 'resetpass':
				$this->resetPass($_SESSION['email']);
			break;

			case 'delresetpass':
				unset($_SESSION['progressBar']);
				unset($_SESSION['email']);
				unset($_SESSION['resetpass']);
			break;

			case 'delPass':
				$this->delCookie();
			break;
		}

		load_view();
	}

	public function login($email, $accesstype, $pass = null, $remember = null)
	{
		if (strlen($email) != 0)
		{
			switch ($accesstype) {
				case 'local':
					$info = (strlen($pass) != 0) ? parent::logInfo($email, $pass) : false;
					break;

				case 'social':
					$info = parent::logInfo($email);
					break;

				default:
					$info = false;
					break;
			}

			if($info)
			{
				if ($info === 'firstIn')
				{
					$key = $this->getKey(50);

					if (parent::setResetToken($email, $key))
					{
						$_SESSION['gestion'] = 'reset';
						$_SESSION['token'] = $key;
					}
				}
				else
				{
					if (!is_null($remember) && $remember = '1')
					{
						$token = $this->getKey(100);

						if (parent::setCookieToken($email, $pass, $token)) {
							setcookie('MONSTER', $token, strtotime( '+365 days' ));
						}
					}
				}

				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	public function newregister($name, $email, $position = '', $accesstype = null) {
		if (parent::available_mail($email)) {
			$pwd = password_hash($this->getKey(8), PASSWORD_DEFAULT, ['cost' => 10]);
			return parent::useregister($name, $email, $position, $pwd, $accesstype);
		}else {
			return false;
		}
	}

	public function delCookie() {
		if (isset($_COOKIE['MONSTER'])) {
			parent::sql("DELETE FROM tbl_cookies WHERE sessiontoken = '".$_COOKIE['MONSTER']."'");
			setcookie('MONSTER', '', 1);
		}

	}

	public function resetPass($email)
	{
		$asunto = 'Restablecer de contraseña';

		if (isset($_SESSION['progressBar']))
		{
			unset($_SESSION['progressBar']);
		}

		if (strlen($email) != 0)
		{
			$key = $this->getKey(50);

			if (parent::setResetToken($email, $key))
			{
				$html = '
				<!DOCTYPE html>
				<html lang="es-SV">
					<head>
						<meta charset="utf-8">
						<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
						<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
						<title>'.APP_NAME.'</title>
					</head>
					<body>
						<div class="container-fluid">
							<div class="row mt-3">
								<div class="col-3"></div>
								<div class="col-6 border border-dark">
									<div class="container">
										<div class="row mt-2">
				 							<div class="col-12 text-center">
												<img src="dist/img/logo-mail.png">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-12 text-center">
												<h3 class="display-4">Restablecer contraseña</h3>
											</div>
										</div>
										<div class="row">
											<div class="col-12 text-center">
												<p>Recibimos una solicitud para restablecer tu contraseña, si fuiste tú, haz clic sobre el siguiente enlace:</p>
											</div>
										</div>
										<div class="row">
											<div class="col-12 text-center">
												<a href="'.URL.'?action=reset&value='.$key.'" class="btn btn-primary" target="_blank">RESTABLECER CONTRASEÑA</a>
											</div>
										</div>
										<div class="row mt-3">
											<div class="col-12 text-center">
												<p>
													Si no quieres restablecer tu contraseña, ignora este mensaje y continua ingresando con tu contraseña actual.
												</p>
												<p>
													Gracias por confiar en nosotros.
												</p>
												<p>
													Atentamente:<br>
													<strong>'.APP_NAME.'</strong>
												</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-3"></div>
							</div>
						</div>
					</body>
				</html>
				';

				if ($this->sendMail($email, $asunto, $html))
				{
					$_SESSION['resetpass'] = true;
				}
				else
				{
					$_SESSION['resetpass'] = false;
				}
			}
			else
			{
				$_SESSION['resetpass'] = false;
			}
		}
	}

	public function resetPassword($pass)
	{
		$arr_pass = str_split($pass);

		$banco = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789abcdefghijklmnñopqrstuvwxyz_@-$!';

		$arr_banco = str_split($banco);

		$x = true;

		foreach ($arr_pass as $valor_pass) {
	        if (!in_array($valor_pass, $arr_banco)) { $x = false; }
		}

		if ($x)
		{
			$password = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);

			if (parent::recoverPassword($password, $_SESSION['token']))
				return true;
			else
				return false;
		}
	}

	protected function getKey($length)
	{
	    $cadena = "ABCDFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
	    $longitudCadena = strlen($cadena);
	    $pass = "";
	    for($i=1 ; $i<=$length ; $i++){
	        $pos=rand(0,$longitudCadena-1);
	        $pass .= substr($cadena,$pos,1);
	    }
	    return $pass;
	}

	public function date_time($request, $date = null)
    {
        date_default_timezone_set("America/El_Salvador");
        setlocale(LC_TIME, "spanish");

        switch ($request)
        {
        	case 'format':
        		$date = str_replace("/", "-", $date);
        		return strftime("%d/%B/%Y", strtotime(date('d-M-Y', strtotime($date))));
        		break;

            case 'date':
                return strftime("%d/%B/%Y", strtotime(date('d-M-Y', time())));
                break;

            case 'datadate':
                return date('Y-m-d', time());
                break;

            case 'time':
                return date('H:i:s', time());
                break;

            default:
                return false;
                break;
        }
    }

	public function sweetAlert($btnid, $data = null, $successtext, $failtext, $type, $timer = 2000, $clear = null, $addjs = '')
	{
		if (!is_null($data)) {
			$info = "";
			foreach ($data as $val) { $info .= "var {$val} = $('#{$val}').val(); "; }

			$route = "var route = '{$btnid}=";
			foreach ($data as $key => $val) { $route .= ((count($data)-1) == $key) ? "&{$val}='+{$val}" : "&{$val}='+{$val}+'"; }
			$route .= ";";

			if (!is_null($clear)) {
				$clear = "";
				foreach ($data as $val) { $clear .= "$('#{$val}').val(''); "; }
			}else {
				$clear = "";
			}

		}else {
			$info = "var id = $('#{$btnid}').val();";
			$route = "var route = '{$btnid}=&id='+id;";
			$clear = "";
		}

		$script = "
			$('#{$btnid}').click(() => {
				{$info}
				{$route}
				$.ajax({
					type: 'post',
					url: '{$type}_data',
					data: route
				})
				.done((res) => {
					var Toast = Swal.mixin({
						toast: false,
						position: 'center',
						showConfirmButton: false,
						timer: '{$timer}',
						timerProgressBar: true
					});
					if (res) {
						Toast.fire({
							icon: 'success',
							title: '😃 Success!! 🥳',
							text: '{$successtext}'
						});
					}else {
						Toast.fire({
							icon: 'error',
							title: '😦 Fail! 😞',
							text: '{$failtext}'
						});
					}
					{$clear}
					{$addjs}
				});
			});
		";

		echo $script;
	}

    protected function sendMail($email, $asunto, $html)
	{
		require_once 'plugins/phpMailer/PHPMailerAutoload.php';

		$mensaje = $html;
		$mail = new PHPMailer;
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = MAIL_SMTP_SECURE;
		$mail->Host = MAIL_HOST;
		$mail->Port = MAIL_PORT;
		$mail->Username = MAIL_USERNAME;
		$mail->Password = MAIL_PASSWORD;
		$mail->CharSet = MAIL_ENCRYPTION;
		$mail->From = MAIL_FROM_ADDRESS;
		$mail->FromName = MAIL_FROM_NAME;
		$mail->Subject = $asunto;
		$mail->addAddress($email);
		$mail->MsgHTML($mensaje);

		if($mail->Send()){
			return true;
		}else{
			return false;
		}
	}
}

$objController = new Controller;

$model = new Model;

if (isset($_GET['action']))
{
	if (isset($_GET['value']))
		$objController->actions($_GET['action'], $_GET['value']);
	else
		$objController->actions($_GET['action']);
}

if (isset($_POST['reset-pass']))
{
	if (strlen($_POST['email']) != 0)
	{
		$_SESSION['progressBar'] = 1;

		$_SESSION['email'] = $_POST['email'];
	}
	else
	{
		$_SESSION['progressBar'] = 0;
	}

	load_view();
}