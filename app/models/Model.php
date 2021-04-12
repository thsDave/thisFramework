<?php

require_once APP.'/config/Conection.php';

class Model extends Conection
{
	public function sql($query)
	{
		$c = parent::conectar();
		$c->set_charset('utf8');
		$res = $c->query($query);
        parent::desconectar();
		return $res;
	}

    public function logInfo($email, $pass = null)
    {
        $res = $this->sql("SELECT * FROM tbl_users WHERE email = '{$email}' AND idstate = 1");

        if ($res->num_rows > 0)
        {
            $user = $res->fetch_assoc();

            if (!is_null($pass))
                $iduser = (password_verify($pass, $user['pass'])) ? $user['iduser'] : false;
            else
                $iduser = $user['iduser'];

            if ($iduser)
            {
                $stmt = $this->sql("call sp_getlvl({$iduser})");

                if ($stmt)
                {
                    $data = $stmt->fetch_assoc();
                    $level = $data['level'];

                    $res = $this->sql("SELECT COUNT(*) AS 'total' FROM `tbl_inputs` WHERE iduser = {$iduser}");

                    $count = $res->fetch_assoc();

                    if ($count['total'] > 0)
                    {
                        $this->sql("INSERT INTO `tbl_inputs`(`iduser`) VALUES ({$iduser})");
                        $_SESSION['log'] = $this->infoUsuario($iduser);
                        return true;
                    }
                    else
                    {
                        return 'firstIn';
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

    public function salida($id)
    {
        $this->sql("INSERT INTO `tbl_outputs`(`iduser`) VALUES ({$id})");
    }

	public function infoUsuario($iduser)
    {
    	$resultado = $this->sql("call sp_userinfo({$iduser})");

    	if ($resultado->num_rows > 0)
		{
			$info = [];

			while ($fila = $resultado->fetch_assoc())
			{
                $info['id'] = $fila['iduser'];
				$info['name'] = $fila['name'];
				$info['email'] = $fila['email'];
				$info['level'] = $fila['level'];
				$info['position'] = $fila['position'];
                $info['pic'] = base64_encode($fila['picture']);
                $info['state'] = $fila['state'];
			}

			return $info;
		}
		else
		{
			return false;
		}
    }

    public function actualizarUsuario()
    {
        $id = $_SESSION['log']['id'];
        $name = $_SESSION['log']['name'];
        $position = $_SESSION['log']['position'];

        $query = "call sp_updtuser('{$name}', '{$position}', $id)";

    	$resultado = $this->sql($query);

    	if ($resultado)
    		return true;
    	else
    		return false;
    }

	public function setCookieToken($email, $pass, $token)
	{
		$resultado = $this->sql("INSERT INTO tbl_cookies VALUES ('{$email}', '{$pass}', '{$token}')");

		if($resultado)
			return true;
		else
			return false;
	}

	public function getCookieToken($token)
	{
		$resultado = $this->sql("SELECT email, pass FROM tbl_cookies WHERE sessiontoken = '{$token}'");

		$info = [];

		while ($campo = $resultado->fetch_assoc())
		{
		    $info['user'] = $campo['email'];
		    $info['pass'] = $campo['pass'];
		}

		if($resultado)
			return $info;
		else
			return false;
	}

	public function setResetToken($email, $token)
	{
        $now = date('Y-m-d');
		$resultado = $this->sql("UPDATE tbl_users SET token = '{$token}', tokendate = '{$now}' WHERE email = '{$email}' AND idstate = 1");
        $res = ($resultado) ? true : false;
		return $res;
	}

	public function validarToken($token)
	{
		if (strlen($token) == 50)
		{
			$resultado = $this->sql("SELECT * FROM tbl_users WHERE token = '{$token}'");

			if ($resultado->num_rows > 0)
				return true;
			else
				return false;
		}
	}

	public function recoverPassword($password, $token)
	{
        $res = $this->sql("SELECT iduser FROM tbl_users WHERE token = '{$token}'");

        if ($res->num_rows > 0)
        {
            unset($_SESSION['token']);

            $dato = $res->fetch_assoc();

            $id = $dato['iduser'];

            $this->sql("INSERT INTO `tbl_inputs`(`iduser`) VALUES ({$id})");

            $token = $this->sql("
                UPDATE
                    tbl_users
                SET
                    tokendate = NULL,
                    pass = '{$password}',
                    token = NULL,
                    idstate = 1
                WHERE
                    iduser = {$id}");

    		if ($token)
    			return true;
    		else
    			return false;
        }
        else
        {
            return false;
        }
	}

	public function validaPassword($currentpwd, $userid)
	{
		$resultado = $this->sql("SELECT * FROM tbl_users WHERE iduser = {$userid}");

		$x = false;

        $dato = $resultado->fetch_assoc();

        return (password_verify($currentpwd, $dato['pass'])) ? true : false;
	}

	public function updatePassword($password, $id)
	{
		$query = "
		UPDATE
			tbl_users
		SET
			pass = '".$password."'
		WHERE
			iduser = ".$id;

		$resultado = $this->sql($query);

		if ($resultado)
			return true;
		else
			return false;
	}

    public function thumbnailprofile()
    {
        $resultado = $this->sql("SELECT * FROM tbl_profilepics");

        if ($resultado)
        {
            $fotos = [];

            while ($data = $resultado->fetch_assoc())
            {
                $fotos['id'][] = $data['idpic'];
                $fotos['name'][] = $data['name'];
                $fotos['format'][] = $data['format'];
                $fotos['pic'][] = base64_encode($data['picture']);
            }

            return $fotos;
        }
        else
        {
            return false;
        }
    }

    public function updtPicProfile($idpic)
    {
        $resultado = $this->sql("UPDATE tbl_users SET idpic = {$idpic} WHERE iduser = {$_SESSION['log']['id']}");

        if ($resultado)
            return true;
        else
            return false;
    }

    public function sttslist()
    {
        $stts = [];
        $res = parent::sql("SELECT * FROM tbl_states;");
        if ($res->num_rows > 0)
        {
            while ($data = $res->fetch_assoc())
            {
                $stts['id'][] = $data['idstate'];
                $stts['state'][] = $data['state'];
            }

            return $stts;
        }
        else
        {
            return false;
        }
    }

    public function userlist()
    {
        $userdata = [];
        $res = $this->sql("call sp_userlist();");
        if ($res->num_rows > 0)
        {
            while ($data = $res->fetch_assoc())
            {
                $userdata['id'][] = $data['iduser'];
                $userdata['name'][] = $data['name'];
                $userdata['email'][] = $data['email'];
                $userdata['position'][] = $data['position'];
                $userdata['level'][] = $data['level'];
                $userdata['state'][] = $data['state'];
            }

            return $userdata;
        }
        else
        {
            return false;
        }
    }

    public function insertComment($comment, $iduser)
    {
        if (!empty($comment)) {
            $query = "INSERT INTO tbl_comments VALUES (NULL, {$iduser}, '{$comment}', CURDATE(), TIME_FORMAT(NOW(), '%H:%i'))";
            return $this->sql($query);
        }else {
            return false;
        }
    }

    public function delComment($idComment, $iduser)
    {
        $res = $this->sql("SELECT * FROM tbl_comments WHERE idcomment = {$idComment} AND iduser = {$iduser}");

        if ($res && $res->num_rows > 0)
        {
            $resultado = $this->sql("DELETE FROM tbl_comments WHERE idcomment = {$idComment}");
        }
    }

    public function getComments()
    {
        $resultado = $this->sql("SELECT * FROM tbl_comments ORDER BY idcomment DESC");

        if ($resultado)
        {
            if ($resultado->num_rows > 0)
            {
                while ($data = $resultado->fetch_assoc())
                {
                    $comments['id'][] = $data['idcomment'];
                    $comments['idUser'][] = $data['iduser'];
                    $comments['comment'][] = $data['comment'];
                    $comments['date'][] = $data['dcomment'];
                    $comments['time'][] = $data['tcomment'];
                }

                return $comments;
            }
            else
            {
                return false;
            }
        }
    }

    public function available_mail($email)
    {
        $res = $this->sql("SELECT * FROM tbl_users WHERE email = '{$email}'");
        return ($res->num_rows > 0) ? false : true;
    }

    public function useregister($name, $email, $position, $pwd, $accesstype)
    {
        if (is_null($accesstype))
            return $this->sql("call sp_useregister('{$name}', '{$email}', '{$pwd}', '{$position}', 0, 5)");
        else
            return $this->sql("call sp_useregister('{$name}', '{$email}', '{$pwd}', '{$position}', 1, 1)");

    }

    protected function delRegister($token)
    {
        $this->sql("DELETE FROM tbl_users WHERE token = '{$token}'");
    }

    public function newreqsupport($subject, $mssg, $id)
    {
        return $this->sql("call sp_supportrequest({$id}, '{$subject}', '{$mssg}')");
    }

    public function historyreq($iduser)
    {
        $query = "SELECT s.subject, s.mssg, s.response, s.idstate, e.state FROM tbl_supports s INNER JOIN tbl_states e ON s.idstate = e.idstate WHERE iduser = {$iduser}";
        $res = $this->sql($query);
        if ($res->num_rows > 0) {
            $list = [];
            while ($data = $res->fetch_assoc()) {
                $list['subject'][] = $data['subject'];
                $list['mssg'][] = $data['mssg'];
                $list['response'][] = $data['response'];
                $list['idstate'][] = $data['idstate'];
                $list['state'][] = $data['state'];
            }
            return $list;
        }else {
            return false;
        }
    }
}