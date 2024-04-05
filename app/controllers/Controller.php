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
				if (parent::token_validator($value))
				{
					$_SESSION['gestion'] = 'reset';
					$_SESSION['token'] = $value;
				}
				else
				{
					session_destroy();
				}
			break;

			case 'confirm':
				if (parent::token_validator($value))
				{
					$_SESSION['gestion'] = 'confirm';
					$_SESSION['token'] = $value;
				}
				else
				{
					session_destroy();
				}
			break;

			case 'delregister':
				if (parent::token_validator($value))
				{
					$_SESSION['gestion'] = 'cancel';
					$_SESSION['tipo_gestion'] = 'registro';
					parent::del_register_restore($value, 'register');
				}
				else
				{
					session_destroy();
				}
			break;

			case 'delrestore':
				if (parent::token_validator($value))
				{
					$_SESSION['gestion'] = 'cancel';
					$_SESSION['tipo_gestion'] = 'restablecimiento';
					parent::del_register_restore($value, 'restore');
				}
				else
				{
					session_destroy();
				}
			break;

			case 'login':
				session_destroy();
			break;

			case 'delresetpass':
				unset($_SESSION['progressBar']);
				unset($_SESSION['email']);
				unset($_SESSION['resetpass']);
			break;

			case 'selectlang':
				$this->selectlang($value);
			break;
		}

		load_view();
	}

	public function login($email, $accesstype, $pass = null, $remember = null, $cookie_token = null)
	{
		if (strlen($email) != 0)
		{
			switch ($accesstype)
			{
				case 'local':
					$info = parent::info_login($email, trim($pass));
				break;

				case 'social':
					$info = parent::info_login($email);
				break;

				default:
					$info = false;
				break;
			}

			if($info)
			{
				if ($info === 'firstIn')
				{
					$key = password_hash($this->getKey(50), PASSWORD_DEFAULT, ['cost' => 10]);

					if (parent::set_reset_token($email, $key))
					{
						$_SESSION['gestion'] = 'reset';
						$_SESSION['token'] = $key;
					}
				}
				else
				{
					if (!is_null($remember) && $remember = '1')
					{
						$token = password_hash($this->getKey(100), PASSWORD_DEFAULT, ['cost' => 10]);

						if (parent::set_cookie_token($email, $pass, $token)) {
							setcookie('user_token', $token, strtotime( '+365 days' ));
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

	public function newregister($data, $accesstype = null)
	{
		$data['access_type'] = (is_null($accesstype)) ? 'local' : $accesstype;

		unset($data['email2']);

		if (parent::available_mail($data['email']))
		{
			$data['password'] = password_hash($this->getKey(8), PASSWORD_DEFAULT, ['cost' => 10]);

			$centinel = true;

			while ($centinel)
			{
				$token = password_hash($this->getKey(70), PASSWORD_DEFAULT, ['cost' => 10]);
				if (!parent::token_validator($token)) {
					$centinel = false;
					break;
				}
			}

			if (parent::set_reset_token($data['email'], $token))
			{
				if (parent::register_user($data))
				{
				 	$html = '
					<!DOCTYPE html>
						<html lang="es-SV">
							<head>
								<meta charset="utf-8">
								<title>'.APP_NAME.'</title>
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
								<h3 style="font-size: 20px !important;">Confirmación de registro</h3>
								<p style="margin-top: 30px;">Hola '.$data['name'].',</p>
								<p style="margin-top: 30px;">Te informamos que has sido registrado exitosamente en <strong>'.APP_NAME.'.</strong></p>
								<p style="margin-top: 30px;">Te damos la bienvenida a nuestra aplicación, para finalizar tu registro, haz clic sobre el siguiente enlace:</p>
								<p><a href="'.URL.'?action=confirm&value='.$token.'" target="_blank">Confirmar correo electrónico</a></p>
								<p style="margin-top: 30px;"><strong>¿No deseas registrarte?</strong></p>
								<p>
									Si no deseas registrarte, haz clic en el siguiente enlace para eliminar tus datos de nuestros registros.
								</p>
								<p>
									<a href="'.URL.'?action=delregister&value='.$token.'" target="_blank" style="color: #DD0000;">Eliminar solicitud de registro</a>
								</p>
								<p style="margin-top: 30px;">
									Gracias por confiar en nosotros.
								</p>
								<p style="margin-top: 30px;">Atentamente:</p>
								<p style="margin-top: 10px;">
									<strong>Administradores de '.APP_NAME.'</strong>
								</p>
								<hr style="margin-top: 30px;">
								<p>Este es un mensaje automático enviado desde un servicio externo, por favor no respondas a este correo.</p>
							</body>
						</html>
					';

					$headers = "MIME-Version: 1.0"."\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
					$headers .= "From: '".MAIL."'"."\r\n";

					if (mail($data['email'], '['.APP_NAME.'] Confirmación de registro', $html, $headers))
					{
						parent::register_mail($data['email'], $token);
					}

					return true;
				}
				else
				{
					parent::del_user($data['email']);

					return false;
				}
			}
			else
			{
				parent::del_user($data['email']);

				return false;
			}

		}
		else
		{
			return false;
		}
	}

	public function send_resetpass($email)
	{
		$data = parent::is_correct_mail($email);

		if ($data)
		{
			$centinel = true;

			while ($centinel)
			{
				$token = password_hash($this->getKey(70), PASSWORD_DEFAULT, ['cost' => 10]);
				if (!parent::token_validator($token)) {
					$centinel = false;
					break;
				}
			}

			$html = '
			<!DOCTYPE html>
				<html lang="es-SV">
					<head>
						<meta charset="utf-8">
						<title>'.APP_NAME.'</title>
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
						<h3 style="font-size: 20px !important;">Restablecimiento de contraseña</h3>
						<p style="margin-top: 30px;">Hola '.$data['name'].',</p>
						<p style="margin-top: 30px;">Recibimos una solicitud para restablecer tu contraseña, si fuiste tú, haz clic sobre el siguiente enlace:</p>
						<a href="'.URL.'?action=reset&value='.$token.'" target="_blank">Restablecer mi contraseña</a>
						<p style="margin-top: 30px;"><strong>¿No has solicitado restablecer tu contraseña?</strong></p>
						<p>
							Es posible que hayan intentado utilizar tu cuenta de correo. Te recomendamos tomar medidas preventivas para asegurarte de que tu cuenta no ha sido vulnerada. Haz clic en el siguiente botón para eliminar la solicitud de registro de nuestro sistema.
						</p>
						<p>
							<a href="'.URL.'?action=delrestore&value='.$token.'" target="_blank" style="color: #DD0000;">Eliminar solicitud de restablecimiento</a>
						</p>
						<p style="margin-top: 30px;">
							Gracias por confiar en nosotros.
						</p>
						<p style="margin-top: 30px;">Atentamente:</p>
						<p style="margin-top: 10px;">
							<strong>Administradores de '.APP_NAME.'</strong>
						</p>
						<hr style="margin-top: 30px;">
						<p>Este es un mensaje automático enviado desde un servicio externo, por favor no respondas a este correo.</p>
					</body>
				</html>
			';

			$headers = "MIME-Version: 1.0"."\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
			$headers .= "From: '".MAIL."'"."\r\n";

			if (mail($data['email'], '['.APP_NAME.'] Restablecimiento de contraseña', $html, $headers))
			{
				return parent::forgetpass_mail($data['email'], $token);
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

	public function resetPassword($pass)
	{
		$arr_pass = str_split($pass);
		$banco = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789abcdefghijklmnñopqrstuvwxyzÁÉÍÓÚáéíóú_@-$!.';
		$arr_banco = str_split($banco);
		$x = true;

		foreach ($arr_pass as $valor_pass)
	        if (!in_array($valor_pass, $arr_banco)) { $x = false; }

		if ($x) {
			$password = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);
			return parent::recover_password($password);
		}
	}

	protected function getKey($length)
	{
	    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz$@/_-";
	    $longitudCadena = strlen($cadena);
	    $pass = "";
	    for($i=1 ; $i<=$length ; $i++)
	    {
	        $pos = rand(0,$longitudCadena-1);
	        $pass .= substr($cadena,$pos,1);
	    }
	    return $pass;
	}

    public function selectlang($lang = null)
    {
    	if (!is_null($lang))
    	{
	    	$langs = parent::language_list();

	    	if (array_search($lang, $langs['lancode']))
	    	{
				$i = array_search($lang, $langs['lancode']);

				$_SESSION['lang']['lanicon'] = $langs['lanicon'][$i];
	    		$_SESSION['lang']['lancode'] = $langs['lancode'][$i];
			}
			else
			{
				$_SESSION['lang']['lanicon'] = '<i class="flag-icon flag-icon-es mr-2"></i>';
	    		$_SESSION['lang']['lancode'] = 'es';
			}
    	}
    	else
    	{
    		$_SESSION['lang']['lanicon'] = '<i class="flag-icon flag-icon-es mr-2"></i>';
    		$_SESSION['lang']['lancode'] = 'es';
    	}
    }

    public function lang_menu()
    {
    	$html = "
    	<li class='nav-item dropdown'>
			<a class='nav-link' data-toggle='dropdown' href='#'>
			  {$_SESSION['lang']['lanicon']}
			</a>
			<div class='dropdown-menu dropdown-menu-right p-0'>
    	";

    	$langs = parent::language_list();

    	foreach ($langs['idlang'] as $i => $id)
    	{
    		$class = ($_SESSION['lang']['lancode'] == $langs['lancode'][$i]) ? 'active' : '';

    		$html .= "
	    		<a href='".URL."?action=selectlang&value={$langs['lancode'][$i]}' class='dropdown-item {$class}'>
			      {$langs['lanicon'][$i]} {$langs['language'][$i]}
			    </a>
    		";
    	}

    	$html .= "
    		</div>
    	</li>";

    	return $html;
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

		return ($mail->Send()) ? true : false;
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