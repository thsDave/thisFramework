<?php

require_once 'Controller.php';

class HomeController extends Controller
{
	public function reqviews($req, $val = null)
	{
		$_SESSION['view'] = $req;

		switch ($req)
		{
			case 'home':
				unset($_SESSION['view']);
			break;

			case 'logout':
				parent::salida($_SESSION['log']['id']);
				session_destroy();
			break;

			default:
				if (is_null($val))
					unset($_SESSION['val']);
				else
					$_SESSION['val'] = $val;
			break;
		}

		load_view();
	}

	private function get_thumbnail_binary($pictures)
	{
		$binarios = [];

		foreach ($pictures['tempName'] as $key => $value)
		{
			require_once "tools/Resize/Resize.php";

			/******* Extraemos el valor binario de la imagen original *******/

	        $fp = fopen($pictures['tempName'][$key], "r");
	        $picture_binary = addslashes(fread($fp, $pictures['fileSize'][$key]));
	        fclose($fp);

	        /******* Guardamos la img temporalmente *******/

	        $folder = "picTemp/";

	        if (!is_dir($folder)) { mkdir($folder, 0777, true); }

            $extension = explode('.', $pictures['fileName'][$key]);
            $pictures['fileName'][$key] = $this->getKey(5).".".$extension[1];

	        $destino = $folder.$pictures['fileName'][$key];
	        opendir($folder);
	        move_uploaded_file($pictures['tempName'][$key], $destino);

	        /******* Creamos el thumbnail de la img *******/

	        $resizeObj = new Resize("picTemp/".$pictures['fileName'][$key]);
	        $resizeObj -> resizeImage(128, 128, 'crop');
	        $location = 'picTemp/thumbnail_'.$this->getKey(5).'.jpg';
	        $resizeObj -> saveImage($location, 100);
	        $thumbnail_binary = addslashes(file_get_contents($location));

	        /******* Eliminamos las imagenes y el directorio temporal *******/

	        unlink($destino);
	        unlink($location);
	        rmdir($folder);

	        $binarios['picture_binary'][] = $picture_binary;
	        $binarios['picture_type'][] = $pictures['fileType'][$key];
	        $binarios['thumbnail_binary'][] = $thumbnail_binary;
		}

		return $binarios;
	}

	private function get_binary($pictures)
	{
		$binarios = [];

		foreach ($pictures['tempName'] as $key => $value)
		{
			/******* Extraemos el valor binario de la imagen original *******/

	        $fp = fopen($pictures['tempName'][$key], "r");
	        $picture_binary = addslashes(fread($fp, $pictures['fileSize'][$key]));
	        fclose($fp);

	        /******* Guardamos el binario y su tipo *******/

	        $binarios['picture_binary'][] = $picture_binary;
	        $binarios['picture_type'][] = $pictures['fileType'][$key];
		}

		return $binarios;
	}

	private function save_file($folder, $files)
	{
		//Armamos la carpeta destino
		$dir = "files/{$folder}/";

		//Verificamos si la ruta existe
		if (!is_dir($dir)) { mkdir($dir, 0777, true); }

		//Extraemos la extensión del archivo
		$extension = explode('.', $files['file']['name']);

		//Cambiamos el nombre del archivo
		$files['file']['name'] = "file.".$extension[1];

		//Verificamos si el archivo existe en la ruta establecida
		if (file_exists($dir.$files['file']['name'])) { unlink($dir.$files['file']['name']); }

		//Guardamos la ruta completa de la imagen
		$route = $dir.$files['file']['name'];

		//Abrimos el directorio
		opendir($dir);

		//Subimos la imagen y retornamos su resultado
		if (move_uploaded_file($files['file']['tmp_name'], $route))
			return true;
		else
			return false;
	}

	public function updtUser()
	{
		unset($_SESSION['updateInfoUser']);

		$datos = [ $_SESSION['log']['name'], $_SESSION['log']['position'] ];

		$x = true; foreach ($datos as $value) { if (empty($value)) { $x = false; break; } }

		if ($x)
			return (parent::actualizarUsuario()) ? true : false;
		else
			return false;
	}

	public function profilepics()
	{
		$fotos = parent::thumbnailprofile();
		$modal = '
		<div class="modal fade" id="picProfile">
			<div class="modal-dialog modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"><i class="fas fa-users"></i> Seleccionar imagen</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-borderless">
							<tbody>';
							$r = round(count($fotos['id']) / 4); $y = 3; $x = 0;
							for ($i = 0; $i <= $r; $i++)
							{
								$modal .= '<tr>';
								for ($j = $x; $j <= $y; $j++)
								{
									if ($j != count($fotos['id']))
									{
										$modal .= '
										<td>
											<a href="'.URL.'?event=updtpic&val='.$fotos['id'][$j].'">
												<img src="data:'.$fotos['format'][$j].';base64,'.$fotos['pic'][$j].'" class="w-75 imgProfile">
											</a>
										</td>';
									}
									else
									{
										break;
									}
								}
								$modal .= '</tr>';
								$x = $j; $y += ($i == $r) ? 3 : 4;
							}
							$modal .= '
							</tbody>
						</table>
					</div>
					<div class="modal-footer bg-dark justify-content-between"></div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->';
		return $modal;
	}

	public function updtpic($id)
	{
		if (parent::updtPicProfile($id)) {
			$info = parent::infoUsuario($_SESSION['log']['id']);
        	$_SESSION['log']['pic'] = $info['pic'];
		}

		load_view();
	}

	public function updatePass($currentPass = null, $pass, $password, $iduser)
	{
		$validation = (!is_null($currentPass)) ? parent::validaPassword($currentPass, $iduser) : true;

		if ($validation)
		{
			if (strlen($pass) >= 8 && strlen($password) >= 8)
			{
				if ($pass == $password)
				{
					$arr_pass = str_split($pass);

					$banco = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789abcdefghijklmnñopqrstuvwxyz_@-$!';

					$arr_banco = str_split($banco);

					$x = true;

					foreach ($arr_pass as $valor_pass) { $x = (!in_array($valor_pass, $arr_banco)) ? false : true; }

					if ($x)
					{
						$password = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);

						return (parent::updatePassword($password, $iduser)) ? true : false;
					}
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
		else
		{
			return false;
		}

	}

	public function historysupportreq($iduser)
	{
		$body = "";
		$list = parent::historyreq($iduser);
		if ($list) {
			foreach ($list['subject'] as $index => $value) {
				$class = ($list['idstate'][$index] == 5) ? 'badge-warning' : 'badge-success';
				$body .= "
				<div class='card-body p-0'>
					<div class='mailbox-read-info'>
						<div class='row'>
							<div class='col-8'>
								<h5>Asunto: {$value}</h5>
								<h6 class='mt-2'>From: {$_SESSION['log']['email']}</h6>
							</div>
							<div class='col-4'>
								<span class='badge {$class} float-right'>{$list['state'][$index]}</span>
							</div>
						</div>
					</div>
					<div class='mailbox-read-message'>
						<p><strong>Mensaje:</strong></p>
						<p>{$list['mssg'][$index]}</p>
						<hr>
						<p><strong>Respuesta:</strong></p>
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
		if (isset($_SESSION['view'])) {
			if ($_SESSION['view'] == $view)
				return 'active';
			else
				return '';
		}else {
			return '';
		}
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

	public function showComments()
	{
		$comments = parent::getComments();

		if ($comments)
		{
			foreach ($comments['id'] as $key => $value)
			{
				echo '
				<div class="direct-chat-msg">
					<div class="direct-chat-infos clearfix">
						<span class="direct-chat-name float-left">
						'.$_SESSION['log']['name'].'
						</span>
						<span class="direct-chat-timestamp float-right">
						'.date_format(date_create($comments['date'][$key]), 'd-M-Y').'
						'.$comments['time'][$key].'
						</span>
					</div>
					<img class="direct-chat-img" src="data:image/png;base64,'.$_SESSION['log']['pic'].'">
					<div class="direct-chat-text">
						'.$comments['comment'][$key].'
					</div>';

				if ($_SESSION['log']['id'] == $comments['idUser'][$key])
				{
					echo '
					<a href="'.URL.'internal_data?delComment='.$value.'" class="text-sm text-danger">Eliminar</a>';
				}
				echo '</div>';
			}
		}
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
		session_destroy();
		load_view();
	}
}

$objHome = new HomeController;

if (isset($_GET['req']))
{
	if (isset($_GET['val']))
		$objHome->reqviews($_GET['req'], $_GET['val']);
	else
		$objHome->reqviews($_GET['req']);
}