<?php

namespace Models;

use Config\Dbcon;

class Model extends Dbcon
{
	private function sql($query)
	{
		$c = parent::conectar();
		$c->set_charset('utf8');
		$res = $c->query($query);
        parent::desconectar();
		return $res;
	}

	protected function setResetToken($email, $token)
	{
        $now = date('Y-m-d');
		$resultado = $this->sql("UPDATE tbl_users SET token = '{$token}', tokendate = '{$now}' WHERE email = '{$email}' AND idstate = 1");
        $res = ($resultado) ? true : false;
		return $res;
	}

	protected function pendingRegisterMails()
    {
        $res = $this->sql("SELECT * FROM tbl_users WHERE registermail = 0 AND idstate = 5");

        if ($res->num_rows > 0)
        {
            $userdata = [];
            if ($res) {
                while ($data = $res->fetch_assoc())
                {
                    $userdata['id'][] = $data['iduser'];
                    $userdata['name'][] = $data['name'];
                    $userdata['email'][] = $data['email'];
                }
            }
            return $userdata;
        }
        else
        {
            return false;
        }
    }

    protected function pendingSupportMails()
    {
        $res = $this->sql("SELECT s.*, u.name, u.email FROM tbl_supports s INNER JOIN tbl_users u ON s.iduser = u.iduser WHERE s.sendmail = 0 AND s.idstate = 5");

        if ($res->num_rows > 0)
        {
            $info = [];
            if ($res) {
                while ($data = $res->fetch_assoc())
                {
                    $info['idsupport'][] = $data['idsupport'];
                    $info['subject'][] = $data['subject'];
                    $info['mssg'][] = $data['mssg'];
                    $info['name'][] = $data['name'];
                    $info['email'][] = $data['email'];
                }
            }
            return $info;
        }
        else
        {
            return false;
        }
    }

    protected function updatesupportreq($id)
    {
        return $this->sql("UPDATE tbl_supports SET sendmail = 1 WHERE idsupport = {$id}");
    }

    protected function mails_sent($id, $token)
    {
        $now = date('Y-m-d');
        if ($this->sql("UPDATE tbl_users SET token = '{$token}', tokendate = '{$now}', registermail = 1 WHERE iduser = {$id}"))
            return true;
        else
            return false;
    }

    protected function savelog($id, $mensaje)
    {
        $this->sql("INSERT INTO tbl_logscron VALUES (NULL, {$id}, '{$mensaje}')");
    }
}