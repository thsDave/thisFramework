<?php

require_once 'Model.php';

class Super extends Model
{
	public function deleteuser($id)
    {
        return parent::pst("UPDATE tbl_users SET idstatus = 2 WHERE iduser = :id", ['id' => $id], false);
    }

    public function getsupportreq($id)
    {
    	$res = parent::pst("CALL sp_getsupportreq(:id)", ['id' => $id]);

    	if (!empty($res))
        {
            $info = [];

            foreach ($res as $val)
            {
                $info['idsupport'] = $val->idsupport;
                $info['name'] = $val->name;
                $info['subject'] = $val->subject;
                $info['mssg'] = $val->mssg;
                $info['response'] = $val->response;
            }

            return $info;
        }
        else
        {
            return false;
        }
    }

    public function savesupportres($id, $resp)
    {
    	return parent::pst("CALL sp_savesupportres(:id, :resp)", ['id' => $id, 'resp' => $resp], false);
    }

    public function datareport($request)
    {
    	$res = parent::pst("CALL sp_datareport(:req)", ['req' => $request]);

    	if (!empty($res))
    	{
    		$data = [];

    		foreach ($res as $val)
    		{
    			$data['nombre'][] = $val->nombre;
				$data['email'][] = $val->email;
				$data['cargo'][] = $val->cargo;
				$data['permiso'][] = $val->permiso;
				$data['tipo_registro'][] = $val->tipo_registro;
				$data['idioma'][] = $val->idioma;
				$data['imagen'][] = $val->imagen;
				$data['estado'][] = $val->estado;

				switch ($request) {
					case 'supports':
						$data['asunto'][] = $val->asunto;
		                $data['mensaje'][] = $val->mensaje;
		                $data['respuesta'][] = $val->respuesta;
					break;

					case 'comments':
						$data['comentario'][] = $val->comentario;
		                $data['fecha'][] = $val->fecha;
					break;
				}
    		}

    		return $data;
    	}
    	else
    	{
    		return false;
    	}
    }
}