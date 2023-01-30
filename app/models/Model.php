<?php

require_once APP.'/config/Connection.php';

class Model extends Connection
{
    #--------------------------------------------------
    // Preparación de declaraciones de consultas sql
    #--------------------------------------------------

	protected function pst($query, $arr_data = [], $expect_values = true)
    {
        $pdo = parent::connect();
        $pst = $pdo->prepare($query);
        if ($pst->execute($arr_data)) {
            if ($expect_values)
                $res = $pst->fetchAll();
            else
                $res = true;
        }else {
            $res = false;
        }
        return $res;
    }

    #--------------------------------------------------
    // Métodos para el control de usuarios
    #--------------------------------------------------

    public function register_user($arr_data)
    {
        return $this->pst("CALL sp_useregister(:name, :email, :password, :lang, 3, 0, 3, :access_type, :country)", $arr_data, false);
    }

    public function new_user($arr_data)
    {
        $arr_data['password'] = password_hash($arr_data['pass'], PASSWORD_DEFAULT, ['cost' => 10]);
        return $this->pst("CALL sp_newuser(:name, :email, :password, :lang, :level, :country)", $arr_data, false);
    }

    public function info_login($email, $pass = null, $cookie_token = null)
    {
        $cookie_token = (!is_null($cookie_token)) ? $this->pst("SELECT * FROM tbl_cookies WHERE sessiontoken = :token", ['token' => $cookie_token], false) : true;

        if ($cookie_token)
        {
            $res = $this->pst("SELECT * FROM tbl_users WHERE email = :email AND idstatus = 1", ['email' => $email]);

            if (!empty($res))
            {
                if (!is_null($pass))
                    $iduser = (password_verify($pass, $res[0]->pass)) ? $res[0]->iduser : false;
                else
                    $iduser = $res[0]->iduser;

                if ($iduser)
                {
                    $res = $this->pst("CALL sp_getlvl(:iduser)", ['iduser' => $iduser]);

                    if (!empty($res))
                    {
                        $level = $res[0]->level;

                        $res = $this->pst("SELECT COUNT(*) AS 'total' FROM tbl_inputs WHERE iduser = :iduser", ['iduser' => $iduser]);

                        if (!empty($res))
                        {
                            if ($res[0]->total > 0)
                            {
                                // Habilitar las siguientes lineas en caso se necesite actualizar información del usuario en futuras actualizaciones

                                // $res = $this->pst("SELECT COUNT(*) AS 'total' FROM tbl_welcome WHERE iduser = :iduser", ['iduser' => $iduser]);

                                // if (!empty($res) && $res[0]->total == 0 )
                                //     $_SESSION['view'] = "updateinfo";

                                $_SESSION['session_appname'] = $this->user_info($iduser);

                                $_SESSION['lang'] = [ 'lanicon' => $_SESSION['session_appname']['lanicon'], 'lancode' => $_SESSION['session_appname']['lancode'] ];

                                $this->pst("INSERT INTO tbl_inputs(iduser) VALUES (:iduser)", ['iduser' => $iduser], false);

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

    public function user_info($iduser)
    {
        $res = $this->pst("CALL sp_userinfo(:iduser)", ['iduser' => $iduser]);

        if (!empty($res))
        {
            $info = [];

            foreach($res as $val)
            {
                $name = explode(' ', $val->name);

                $info['id'] = $val->iduser;
                $info['name'] = $val->name;
                $info['starter_name'] = $name[0];
                $info['email'] = $val->email;
                $info['level'] = $val->level;
                $info['alias'] = $val->alias;
                $info['idlvl'] = $val->idlvl;
                $info['idlang'] = $val->idlang;
                $info['lancode'] = $val->lancode;
                $info['lanicon'] = $val->lanicon;
                $info['pic'] = base64_encode($val->picture);
                $info['status'] = $val->status;
                $info['idstatus'] = $val->idstatus;
                $info['idcountry'] = $val->idcountry;
                $info['country'] = $val->country;
            }

            return $info;
        }
        else
        {
            return false;
        }
    }

    public function user_info_by_token($token)
    {
        $res = $this->pst("SELECT * FROM tbl_users WHERE token = :token", ['token' => $token]);

        if (!empty($res))
        {
            $info = [];

            $info['id'] = $res[0]->iduser;
            $info['name'] = $res[0]->name;
            $info['email'] = $res[0]->email;

            return $info;
        }
        else
        {
            return false;
        }
    }

    public function user_list()
    {
        $res = $this->pst("CALL sp_userlist(:idlvl, :idcountry)", ['idlvl' => $_SESSION['session_appname']['idlvl'], 'idcountry' => $_SESSION['session_appname']['idcountry']]);

        if (!empty($res))
        {
            $userdata = [];

            foreach ($res as $val)
            {
                $userdata['id'][] = $val->iduser;
                $userdata['name'][] = $val->name;
                $userdata['email'][] = $val->email;
                $userdata['language'][] = $val->language;
                $userdata['level'][] = $val->level;
                $userdata['alias'][] = $val->alias;
                $userdata['registertype'][] = $val->registertype;
                $userdata['status'][] = $val->status;
                $userdata['idcountry'][] = $val->idcountry;
                $userdata['country'][] = $val->country;
            }

            return $userdata;
        }
        else
        {
            return false;
        }
    }

    public function update_user($data_user)
    {
        $res = $this->pst("CALL sp_updtuser(:name, :level, :lang, :status, :country, :id)", $data_user, false);

        if (!isset($_SESSION['val']))
            $_SESSION['session_appname'] = $this->user_info($_SESSION['session_appname']['id']);

        return ($res) ? true : false;
    }

    public function thumbnail_profile()
    {
        $res = $this->pst("SELECT * FROM tbl_profilepics");

        if (!empty($res))
        {
            $fotos = [];

            foreach ($res as $val)
            {
                $fotos['id'][] = $val->idpic;
                $fotos['name'][] = $val->name;
                $fotos['format'][] = $val->format;
                $fotos['pic'][] = base64_encode($val->picture);
            }

            return $fotos;
        }
        else
        {
            return false;
        }
    }

    public function update_pic_profile($idpic)
    {
        $arr_data = [
            'idpic' => $idpic,
            'iduser' => $_SESSION['session_appname']['id']
        ];

        $res = $this->pst("UPDATE tbl_users SET idpic = :idpic WHERE iduser = :iduser", $arr_data, false);

        $_SESSION['session_appname'] = $this->user_info($_SESSION['session_appname']['id']);

        return ($res) ? true : false;
    }

    protected function del_register($token)
    {
        $this->pst("DELETE FROM tbl_users WHERE token = :token", ['token' => $token], false);
    }

    public function del_user($email)
    {
        $this->pst("DELETE FROM tbl_users WHERE email = :email", ['email' => $email], false);
    }

    #--------------------------------------------------
    // CRUD tbl_countries
    #--------------------------------------------------

    public function countries_list()
    {
        $query = "SELECT c.*, s.status FROM tbl_countries c INNER JOIN tbl_status s ON c.idstatus = s.idstatus";

        $res = $this->pst($query);

        if (!empty($res))
        {
            $data = [];

            foreach ($res as $val)
            {
                $data['idcountry'][] = $val->idcountry;
                $data['country'][] = $val->country;
                $data['badge'][] = $val->badge;
                $data['isocode'][] = $val->isocode;
                $data['idstatus'][] = $val->idstatus;
                $data['status'][] = $val->status;
            }

            return $data;
        }
        else
        {
            return false;
        }
    }

    public function info_country($idcountry)
    {
        $query = "SELECT c.*, s.status FROM tbl_countries c INNER JOIN tbl_status s ON c.idstatus = s.idstatus WHERE idcountry = :id";

        $res = $this->pst($query, ['id' => $idcountry]);

        if (!empty($res))
        {
            $data = [];

            foreach ($res as $val)
            {
                $data['idcountry'] = $val->idcountry;
                $data['country'] = $val->country;
                $data['badge'] = $val->badge;
                $data['isocode'] = $val->isocode;
                $data['idstatus'] = $val->idstatus;
                $data['status'] = $val->status;
            }

            return $data;
        }
        else
        {
            return false;
        }
    }

    public function ch_countries_status($data)
    {
        $res = $this->pst("UPDATE tbl_countries SET idstatus = :status WHERE idcountry = :id", $data, false);

        return $res;
    }

    public function new_country($data)
    {
        $res = $this->pst("INSERT INTO tbl_countries VALUES (NULL, :country, :badge, :isocode, 1)", $data, false);

        return $res;
    }

    public function edit_country($data)
    {
        $res = $this->pst("UPDATE tbl_countries SET country = :country, badge = :badge, isocode = :isocode WHERE idcountry = :id", $data, false);

        return $res;
    }

    #--------------------------------------------------
    // CRUD tbl_languages
    #--------------------------------------------------

    public function language_list()
    {
        $query = "SELECT c.*, s.status FROM tbl_languages c INNER JOIN tbl_status s ON c.idstatus = s.idstatus";

        $res = $this->pst($query);

        if (!empty($res))
        {
            $data = [];

            foreach ($res as $val)
            {
                $data['idlang'][] = $val->idlang;
                $data['language'][] = $val->language;
                $data['lancode'][] = $val->lancode;
                $data['lanicon'][] = $val->lanicon;
                $data['idstatus'][] = $val->idstatus;
                $data['status'][] = $val->status;
            }

            return $data;
        }
        else
        {
            return false;
        }
    }

    public function ch_language_status($data)
    {
        $res = $this->pst("UPDATE tbl_languages SET idstatus = :status WHERE idlang = :id", $data, false);

        return $res;
    }

    public function new_language($data)
    {
        $res = $this->pst("INSERT INTO tbl_languages VALUES (NULL, :language, :lancode, :lanicon, 1)", $data, false);

        return $res;
    }

    public function edit_language($data)
    {
        try {
            $res = $this->pst("UPDATE tbl_languages SET language = :language, lancode = :lancode, lanicon = :lanicon WHERE idlang = :id", $data, false);
        } catch (Exception $e) {
            $res = false;
        }

        return $res;
    }

    #--------------------------------------------------
    // CRUD tbl_welcome
    #--------------------------------------------------

    public function info_welcome($iduser)
    {
        $res = $this->pst("SELECT * FROM tbl_welcome WHERE iduser = :id", ['id' => $iduser]);

        if (!empty($res))
        {
            $data = [];

            foreach ($res as $val)
            {
                $data['infoprofile'] = $val->infoprofile;
                $data['dateinfo'] = $val->dateinfo;
                $data['welcome'] = $val->welcome;
                $data['datewelcome'] = (is_null($val->datewelcome)) ? 0 : $val->datewelcome;
                $data['actionwelcome'] = (is_null($val->actionwelcome)) ? 0 : $val->actionwelcome;
            }

            return $data;
        }
        else
        {
            return false;
        }
    }

    public function welcome_finished($iduser)
    {
        $now = date('Y-m-d');

        $data = [
            'iduser' => $iduser,
            'now' => $now,
            'action' => 'Bienvenida consultada y finalizada'
        ];

        $res = $this->pst("UPDATE tbl_welcome SET welcome = 1, datewelcome = :now, actionwelcome = :action WHERE iduser = :iduser", $data, false);

        return $res;
    }

    public function welcome_denied($iduser)
    {
        $now = date('Y-m-d');

        $data = [
            'iduser' => $iduser,
            'now' => $now,
            'action' => 'Omitido por el usuario'
        ];

        $res = $this->pst("UPDATE tbl_welcome SET welcome = 1, datewelcome = :now, actionwelcome = :action WHERE iduser = :iduser", $data, false);

        return $res;
    }

    public function addwelcome($data)
    {
        $update = $this->pst("UPDATE tbl_users SET name = :name, idcountry = :country, idlang = :lang WHERE iduser = :id", $data, false);

        if ($update) {
            $date = date('Y-m-d');
            return $this->pst("INSERT INTO tbl_welcome VALUES (:iduser, 1, :now, 0, NULL, NULL)", [ 'iduser' => $data['id'], 'now' => $date ], false);
        }else {
            return false;
        }
    }

    #--------------------------------------------------
    // Password
    #--------------------------------------------------

    public function recover_password($pass, $token)
    {
        $data = $this->pst("SELECT iduser FROM tbl_users WHERE token = :token", ['token' => $token]);

        if (!empty($data))
        {
            unset($_SESSION['token']);

            $id = $data[0]->iduser;

            $this->pst("INSERT INTO tbl_inputs(iduser) VALUES (:id)", ['id' => $id], false);

            $arr_data = [
                'pass' => $pass,
                'token' => NULL,
                'td' => NULL,
                'fp' => 0,
                'idstatus' => 1,
                'iduser' => $id
            ];

            $query = "UPDATE tbl_users SET pass = :pass, token = :token, tokendate = :td, forgetpass = :fp, idstatus = :idstatus WHERE iduser = :iduser";

            $res = $this->pst($query, $arr_data, false);

            return ($res) ? true : false;
        }
        else
        {
            return false;
        }
    }

    public function pass_validator($curpass, $iduser)
    {
        $res = $this->pst("SELECT * FROM tbl_users WHERE iduser = {$iduser}");

        return (password_verify($curpass, $res[0]->pass)) ? true : false;
    }

    public function update_password($arr_data)
    {
        return $this->pst("UPDATE tbl_users SET pass = :pass WHERE iduser = :iduser", $arr_data, false);
    }

    #--------------------------------------------------
    // Cookies & Tokens
    #--------------------------------------------------

	public function set_cookie_token($email, $pass, $token)
	{
        $arr_data = [
            'email' => $email,
            'pass' => $pass,
            'token' => $token
        ];

		return $this->pst("INSERT INTO tbl_cookies VALUES (:email, :pass, :token)", $arr_data, false);
	}

	public function get_cookie_token($token)
	{
		$res = $this->pst("SELECT email, pass FROM tbl_cookies WHERE sessiontoken = :token", ['token' => $token]);

        if (!empty($res))
        {
    		$info = [];

    		foreach($res as $val)
    		{
    		    $info['user'] = $val->email;
    		    $info['pass'] = $val->pass;
    		}

            return $info;
        }
        else
        {
            return false;
        }
	}

	public function set_reset_token($email, $token)
	{
        $arr_data = [
            'token' => $token,
            'now' => date('Y-m-d'),
            'email' => $email,
            'id' => 1
        ];

		$res = $this->pst("UPDATE tbl_users SET token = :token, tokendate = :now WHERE email = :email AND idstatus = :id", $arr_data, false);

        return ($res) ? true : false;
	}

	public function token_validator($token)
	{
		$res = $this->pst("SELECT * FROM tbl_users WHERE token = :token", ['token' => $token]);

		if (!empty($res))
			return true;
		else
			return false;
	}

    #--------------------------------------------------
    // Other methods
    #--------------------------------------------------

    public function support_list()
    {
        $res = $this->pst("CALL sp_supportlist()");

        if (!empty($res))
        {
            $supports = [];

            foreach ($res as $val)
            {
                $supports['idsupport'][] = $val->idsupport;
                $supports['name'][] = $val->name;
                $supports['email'][] = $val->email;
                $supports['level'][] = $val->level;
                $supports['subject'][] = $val->subject;
                $supports['mssg'][] = $val->mssg;
                $supports['response'][] = $val->response;
                $supports['idstatus'][] = $val->idstatus;
                $supports['status'][] = $val->status;
            }

            return $supports;
        }
        else
        {
            return false;
        }
    }

    public function outputs($id)
    {
        $this->pst("INSERT INTO tbl_outputs(iduser) VALUES (:foca)", ['foca' => $id], false);
    }

    public function status_list()
    {
        $res = $this->pst("SELECT * FROM tbl_status");

        if (!empty($res))
        {
            $stts = [];

            foreach ($res as $val)
            {
                $stts['id'][] = $val->idstatus;
                $stts['status'][] = $val->status;
            }

            return $stts;
        }
        else
        {
            return false;
        }
    }

    public function level_list()
    {
        $res = $this->pst("SELECT * FROM tbl_levels");

        if (!empty($res))
        {
            $data = [];

            foreach ($res as $val)
            {
                $data['id'][] = $val->idlvl;
                $data['level'][] = $val->level;
                $data['alias'][] = $val->alias;
            }

            return $data;
        }
        else
        {
            return false;
        }
    }

    public function is_correct_mail($email)
    {
        $res = $this->pst("SELECT * FROM tbl_users WHERE email = :email", ['email' => $email]);

        if (!empty($res))
        {
            $data = [];

            $data['iduser'] = $res[0]->iduser;
            $data['name'] = $res[0]->name;
            $data['email'] = $res[0]->email;

            return $data;
        }
        else
        {
            return false;
        }
    }

    public function mails_sent($email, $token)
    {
        $arr_data = [
            'token' => $token,
            'now' => date('Y-m-d'),
            'register' => 1,
            'email' => $email,
            'status' => 1
        ];

        $query = "UPDATE tbl_users SET token = :token, tokendate = :now, registermail = :register, idstatus = :status WHERE email = :email";

        return $this->pst($query, $arr_data, false);
    }

    public function savelog($id, $mensaje)
    {
        $arr_data = [
            'idlog' => null,
            'idstatus' => $id,
            'mnsj' => $mensaje
        ];

        $this->pst("INSERT INTO tbl_logscron VALUES (:idlog, :idstatus, :mnsj)", $arr_data, false);
    }

    public function recovery_req_on($iduser)
    {
        return $this->pst("UPDATE tbl_users SET forgetpass = 1, idstatus = 3 WHERE iduser = :id", ['id' => $iduser], false);
    }

    public function forgetpass_mail($iduser)
    {
        return $this->pst("UPDATE tbl_users SET forgetpass = 1, idstatus = 3 WHERE iduser = :id", ['id' => $iduser], false);
    }

    public function available_mail($email)
    {
        $res = $this->pst("SELECT * FROM tbl_users WHERE email = :email", ['email' => $email]);
        return (empty($res)) ? true : false;
    }

    public function new_support_request($subject, $mssg, $id)
    {
        $arr_data = [
            'id' => $id,
            'subject' => $subject,
            'mssg' => $mssg
        ];

        return $this->pst("CALL sp_supportrequest(:id, :subject, :mssg)", $arr_data, false);
    }

    public function history_request($iduser)
    {
        $query = "SELECT s.subject, s.mssg, s.response, s.idstatus, e.status FROM tbl_supports s INNER JOIN tbl_status e ON s.idstatus = e.idstatus WHERE iduser = :iduser";

        $res = $this->pst($query, ['iduser' => $iduser]);

        if (!empty($res))
        {
            $list = [];

            foreach ($res as $val)
            {
                $list['subject'][] = $val->subject;
                $list['mssg'][] = $val->mssg;
                $list['response'][] = $val->response;
                $list['idstatus'][] = $val->idstatus;
                $list['status'][] = $val->status;
            }

            return $list;
        }
        else
        {
            return false;
        }
    }
}