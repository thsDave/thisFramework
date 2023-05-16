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
        $res = ($pst->execute($arr_data)) ? ($expect_values) ? $pst->fetchAll() : true : false;
        parent::disconnect();
        return $res;
    }

    #--------------------------------------------------
    // Métodos para el control de usuarios
    #--------------------------------------------------

    // principal
    public function register_user($arr_data)
    {
        return $this->pst("CALL sp_useregister(:name, :email, :password, :lang, 3, 0, 3, :access_type, :country)", $arr_data, false);
    }

    // sudo
    public function new_user($arr_data)
    {
        $arr_data['password'] = password_hash($arr_data['pass'], PASSWORD_DEFAULT, ['cost' => 10]);

        unset($arr_data['pass']);

        return $this->pst("CALL sp_newuser(:name, :email, :password, :lang, :level, :country)", $arr_data, false);
    }

    // all levels
    public function info_login($email, $pass, $cookie_token = null)
    {
        $cookie_res = (!is_null($cookie_token)) ? $this->pst("SELECT * FROM tbl_cookies WHERE sessiontoken = :token AND email = :email", ['token' => $cookie_token, 'email' => $email]) : false;

        $pass = ($cookie_res) ? null : $pass;

        $res = $this->pst("SELECT * FROM tbl_users WHERE email = :email AND idstatus = 1", [ 'email' => $email ]);

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

    // admin
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

    // principal
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

    // admin
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

    // all levels
    public function update_user($data_user)
    {
        $res = $this->pst("CALL sp_updtuser(:name, :level, :lang, :status, :country, :id)", $data_user, false);

        if (!isset($_SESSION['val']))
            $_SESSION['session_appname'] = $this->user_info($_SESSION['session_appname']['id']);

        return ($res) ? true : false;
    }

    // all levels
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

    // all levels
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

    // principal
    protected function del_register($token)
    {
        $this->pst("DELETE FROM tbl_users WHERE token = :token", ['token' => $token], false);
    }

    // principal
    public function del_user($email)
    {
        $this->pst("DELETE FROM tbl_users WHERE email = :email", ['email' => $email], false);
    }

    // all levels
    public function datatable($table, $index_column, $columns)
    {
        $sQuery = "SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $columns))." FROM `".$table."`";

        $res = $this->pst($sQuery);

        if (!empty($res))
        {
            $data = [];

            $correlativo = 1;

            foreach ($res as $val)
            {
                $val->no = $correlativo;

                //personalización de timestamp
                $date = date('d/m/Y',strtotime($val->timestamp));
                $hour = date('H:i:s A',strtotime($val->timestamp));
                $val->timestamp = "🗓️ {$date} ⌚ {$hour}";

                $data[] = (array) $val;

                $correlativo++;
            }

            return $data;
        }
        else
        {
            return false;
        }
    }

    #--------------------------------------------------
    // CRUD tbl_countries
    #--------------------------------------------------

    // all levels
    public function countries_list()
    {
        $query = "SELECT c.*, s.status FROM tbl_countries c INNER JOIN tbl_status s ON c.idstatus = s.idstatus WHERE c.idstatus <> 11";

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

    // all levels
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

    // sudo
    public function ch_countries_status($data)
    {
        $res = $this->pst("SELECT idstatus FROM tbl_countries WHERE idcountry = :id", $data);

        $data['status'] = ($res[0]->idstatus == 2) ? 1 : 2;

        $update = $this->pst("UPDATE tbl_countries SET idstatus = :status, timestamp = NOW() WHERE idcountry = :id", $data, false);

        return $update;
    }

    // sudo
    public function new_country($data)
    {
        $res = $this->pst("INSERT INTO tbl_countries VALUES (NULL, :country, :badge, :isocode, 1, NOW())", $data, false);

        return $res;
    }

    // sudo
    public function edit_country($data)
    {
        $res = $this->pst("UPDATE tbl_countries SET country = :country, badge = :badge, isocode = :isocode, timestamp = NOW() WHERE idcountry = :id", $data, false);

        return $res;
    }

    // sudo
    public function delete_country($data)
    {
        $res = $this->pst("UPDATE tbl_countries SET idstatus = 11, timestamp = NOW() WHERE idcountry = :id", $data, false);

        return $res;
    }

    #--------------------------------------------------
    // CRUD tbl_languages
    #--------------------------------------------------

    // all levels
    public function language_list()
    {
        $query = "SELECT c.*, s.status FROM tbl_languages c INNER JOIN tbl_status s ON c.idstatus = s.idstatus WHERE c.idstatus = 1";

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

    // sudo
    public function ch_language_status($data)
    {
        $res = $this->pst("SELECT idstatus FROM tbl_languages WHERE idlang = :id", $data);

        $data['status'] = ($res[0]->idstatus == 2) ? 1 : 2;

        $update = $this->pst("UPDATE tbl_languages SET idstatus = :status, timestamp = NOW() WHERE idlang = :id", $data, false);

        return $update;
    }

    // sudo
    public function new_language($data)
    {
        $data['lanicon'] = "<i class='flag-icon flag-icon-{$data['lancode']}' mr-2></i>";

        $lang = $this->pst("SELECT lancode FROM tbl_languages WHERE idstatus = 1 ORDER BY idlang DESC LIMIT 1");

        $last_lancode = (!empty($lang)) ? $lang[0]->lancode : false;

        $res = $this->pst("INSERT INTO tbl_languages VALUES (NULL, :language, :lancode, :lanicon, 1, NOW())", $data, false);

        if ($res)
        {
            if ($last_lancode)
            {
                $last_lang_file = APP.'/config/languages/'.$last_lancode.'.php';

                $new_lang_file = APP.'/config/languages/'.$data['lancode'].'.php';

                if (!copy($last_lang_file, $new_lang_file))
                {
                    $idlang = $this->pst("SELECT idlang FROM tbl_languages WHERE idstatus = 1 AND lancode = :lancode ORDER BY idlang DESC LIMIT 1", ['lancode' => $data['lancode']]);

                    $update = $this->pst("UPDATE tbl_languages SET idstatus = 2 WHERE idlang = :id", [ 'id' => $idlang[0]->idlang ], false);
                }
            }
            else
            {
                $file = fopen(APP.'/config/languages/'.$data['lancode'].'.php', 'x');

                if ($file)
                {
                    $idlang = $this->pst("SELECT idlang FROM tbl_languages WHERE idstatus = 1 AND lancode = :lancode ORDER BY idlang DESC LIMIT 1", ['lancode' => $data['lancode']]);

                    $update = $this->pst("UPDATE tbl_languages SET idstatus = 2 WHERE idlang = :id", [ 'id' => $idlang[0]->idlang ], false);
                }
                else
                {
                    fclose($file);
                }
            }
        }

        return $res;
    }

    // sudo
    public function edit_language($data)
    {
        try
        {
            $lancode = $this->pst("SELECT lancode FROM tbl_languages WHERE idlang = :id", [ 'id' => $data['id'] ]);

            if (!empty($lancode))
            {
                $lang_file = APP.'/config/languages/'.$lancode[0]->lancode.'.php';

                $new_lang_file = APP.'/config/languages/'.$data['lancode'].'.php';

                if ($lang_file == $new_lang_file)
                {
                    $data['lanicon'] = "<i class='flag-icon flag-icon-{$data['lancode']}' mr-2></i>";

                    return $this->pst("UPDATE tbl_languages SET language = :language, lancode = :lancode, lanicon = :lanicon, timestamp = NOW() WHERE idlang = :id", $data, false);
                }
                else
                {
                    $data['lanicon'] = "<i class='flag-icon flag-icon-{$data['lancode']}' mr-2></i>";

                    $res = $this->pst("UPDATE tbl_languages SET language = :language, lancode = :lancode, lanicon = :lanicon, timestamp = NOW() WHERE idlang = :id", $data, false);

                    if (!file_exists($new_lang_file))
                    {
                        if (!copy($lang_file, $new_lang_file))
                        {
                            $this->pst("UPDATE tbl_languages SET idstatus = 2 WHERE idlang = :id", [ 'id' => $data['id'] ], false);
                        }
                    }

                    return $res;
                }
            }
            else
            {
                return false;
            }
        }
        catch (Exception $e)
        {
            $res = false;
        }

        return $res;
    }

    // sudo
    public function delete_language($data)
    {
        $res = $this->pst("UPDATE tbl_languages SET idstatus = 11, timestamp = NOW() WHERE idlang = :id", $data, false);

        return $res;
    }

    #--------------------------------------------------
    // CRUD tbl_welcome
    #--------------------------------------------------

    // all levels
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

    // all levels
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

    // all levels
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

    // all levels
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

    // principal
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

    // principal
    public function pass_validator($curpass, $iduser)
    {
        $res = $this->pst("SELECT * FROM tbl_users WHERE iduser = {$iduser}");

        return (password_verify($curpass, $res[0]->pass)) ? true : false;
    }

    // principal
    public function update_password($arr_data)
    {
        return $this->pst("UPDATE tbl_users SET pass = :pass WHERE iduser = :iduser", $arr_data, false);
    }

    #--------------------------------------------------
    // Cookies & Tokens
    #--------------------------------------------------

	// principal
    public function set_cookie_token($email, $pass, $token)
	{
        $arr_data = [
            'email' => $email,
            'pass' => $pass,
            'token' => $token
        ];

		return $this->pst("INSERT INTO tbl_cookies VALUES (:email, :pass, :token, NOW())", $arr_data, false);
	}

	// principal
    public function get_cookie_token($token)
	{
		$res = $this->pst("SELECT email FROM tbl_cookies WHERE sessiontoken = :token", ['token' => $token]);

        return (!empty($res)) ? $res[0]->email : false;
	}

	// principal
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

	// principal
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

    // sudo
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

    // all levels
    public function outputs($id)
    {
        $this->pst("INSERT INTO tbl_outputs(iduser) VALUES (:foca)", ['foca' => $id], false);
    }

    // all levels
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

    // admin
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

    // principal
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

    // all levels
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

    // all levels
    public function savelog($id, $mensaje)
    {
        $arr_data = [
            'idlog' => null,
            'idstatus' => $id,
            'mnsj' => $mensaje
        ];

        $this->pst("INSERT INTO tbl_logscron VALUES (:idlog, :idstatus, :mnsj)", $arr_data, false);
    }

    // principal
    public function recovery_req_on($iduser)
    {
        return $this->pst("UPDATE tbl_users SET forgetpass = 1, idstatus = 3 WHERE iduser = :id", ['id' => $iduser], false);
    }

    // principal
    public function forgetpass_mail($iduser)
    {
        return $this->pst("UPDATE tbl_users SET forgetpass = 1, idstatus = 3 WHERE iduser = :id", ['id' => $iduser], false);
    }

    // principal
    public function available_mail($email)
    {
        $res = $this->pst("SELECT * FROM tbl_users WHERE email = :email", ['email' => $email]);
        return (empty($res)) ? true : false;
    }

    // all levels
    public function new_support_request($subject, $mssg, $id)
    {
        $arr_data = [
            'id' => $id,
            'subject' => $subject,
            'mssg' => $mssg
        ];

        return $this->pst("CALL sp_supportrequest(:id, :subject, :mssg)", $arr_data, false);
    }

    // all levels
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