<?php

require_once APP.'/config/Connection.php';

class Model extends Connection
{
    #--------------------------------------------------
    // Preparación de declaraciones de consultas sql (pst: PDO Statement)
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

        $res = $this->pst("CALL sp_newuser(:name, :email, :password, :lang, :level, :country)", $arr_data);

        if ($res) {
            $this->savelog(1, "Creación de usuario con id: {$res[0]->iduser} en la sección 'nuevo' del módulo de usuarios", $_SESSION[USER_SESSION]['id']);
            return true;
        }else {
            return false;
        }

    }

    // all levels
    public function info_login($email, $pass)
    {
        $user = $this->pst("SELECT * FROM tbl_users WHERE email = :email AND idstatus = 1 OR idstatus = 3", [ 'email' => $email ]);

        if (!empty($user))
        {
            $iduser = (password_verify($pass, $user[0]->pass)) ? $user[0]->iduser : false;

            if (!is_null($user[0]->token)) { $_SESSION['token'] = $user[0]->token; }

            if ($iduser)
            {
                $idstatus = $user[0]->idstatus;
                $token = $user[0]->token;

                $res = $this->pst("CALL sp_getlvl(:iduser, :idstatus)", ['iduser' => $iduser, 'idstatus' => $idstatus]);

                if (!empty($res))
                {
                    $level = $res[0]->level;

                    $res = $this->pst("SELECT COUNT(*) AS 'total' FROM tbl_inputs WHERE iduser = :iduser", ['iduser' => $iduser]);

                    if (!empty($res))
                    {
                        if ($res[0]->total > 0)
                        {
                            if ($idstatus == 3)
                            {
                                $_SESSION['token'] = $token;
                                return 'pwdRestore';
                            }
                            else
                            {
                                // Habilitar las siguientes lineas en caso se necesite actualizar información del usuario en futuras actualizaciones

                                // $res = $this->pst("SELECT COUNT(*) AS 'total' FROM tbl_welcome WHERE iduser = :iduser", ['iduser' => $iduser]);

                                // if (!empty($res) && $res[0]->total == 0 )
                                // $_SESSION['view'] = "updateinfo";

                                $_SESSION[USER_SESSION] = $this->user_info($iduser);

                                $_SESSION['lang'] = [ 'lanicon' => $_SESSION[USER_SESSION]['lanicon'], 'lancode' => $_SESSION[USER_SESSION]['lancode'] ];

                                $this->session_log($iduser, 'in');

                                return true;
                            }
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
        $res = $this->pst("CALL sp_userlist(:idlvl, :idcountry)", ['idlvl' => $_SESSION[USER_SESSION]['idlvl'], 'idcountry' => $_SESSION[USER_SESSION]['idcountry']]);

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

        if ($res) {
            if (!isset($_SESSION['val'])) {
                $this->savelog(4, "Se actualizó la información de usuario", $_SESSION[USER_SESSION]['id']);
                $_SESSION[USER_SESSION] = $this->user_info($_SESSION[USER_SESSION]['id']);
            }else {
                $this->savelog(4, "Se actualizó la información del usuario con id: {$data_user['id']}", $_SESSION[USER_SESSION]['id']);
            }
        }

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
            'iduser' => (!isset($_SESSION['val'])) ? $_SESSION[USER_SESSION]['id'] : $_SESSION['val']
        ];

        $res = $this->pst("UPDATE tbl_users SET idpic = :idpic, updated_at = NOW() WHERE iduser = :iduser", $arr_data, false);

        if ($res) {
            if (!isset($_SESSION['val'])) {
                $this->savelog(4, 'Se actualizó la imagen de perfil de usuario', $_SESSION[USER_SESSION]['id']);
            }else {
                $this->savelog(4, "Se actualizó la imagen del perfil del usuario con id: {$_SESSION['val']}", $_SESSION[USER_SESSION]['id']);
            }
        }

        $_SESSION[USER_SESSION] = $this->user_info($_SESSION[USER_SESSION]['id']);

        return ($res) ? true : false;
    }

    // principal
    protected function del_register_restore($token, $type)
    {
        switch ($type)
        {
            case 'register':
                $this->pst("DELETE FROM tbl_users WHERE token = :token", ['token' => $token], false);
            break;

            case 'restore':
                $res = $this->pst("SELECT * FROM tbl_users WHERE token = :token", ['token' => $token]);

                if (!empty($res))
                {
                    $this->pst("UPDATE tbl_users SET token = NULL, tokendate = NULL, forgetpass = 0 WHERE token = :token", ['token' => $token], false);

                    $this->savelog(4, "Se canceló el restablecimiento de contraseña.", $res[0]->iduser);
                }
            break;
        }
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

        $update = $this->pst("UPDATE tbl_countries SET idstatus = :status, updated_at = NOW(), deleted_at = NULL WHERE idcountry = :id", $data, false);

        if ($update) { $this->savelog(4, "Se actualizó el estado de país con id: {$data['id']}", $_SESSION[USER_SESSION]['id']); }

        return $update;
    }

    // sudo
    public function new_country($data)
    {
        $res = $this->pst("CALL sp_insertcountry(:country, :badge, :isocode)", $data);

        if ($res) {
            $this->savelog(3, "Se insertó un nuevo registro de país con id: {$res[0]->idcountry}", $_SESSION[USER_SESSION]['id']);
        }

        return $res;
    }

    // sudo
    public function edit_country($data)
    {
        $res = $this->pst("UPDATE tbl_countries SET country = :country, badge = :badge, isocode = :isocode, updated_at = NOW() WHERE idcountry = :id", $data, false);

        if ($res) { $this->savelog(4, "Se actualizó el registro de país con id: {$data['id']}", $_SESSION[USER_SESSION]['id']); }

        return $res;
    }

    // sudo
    public function delete_country($data)
    {
        $res = $this->pst("UPDATE tbl_countries SET idstatus = 11, deleted_at = NOW() WHERE idcountry = :id", $data, false);

        if ($res) { $this->savelog(5, "Se eliminó el registro de país con id: {$data['id']}", $_SESSION[USER_SESSION]['id']); }

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

        $update = $this->pst("UPDATE tbl_languages SET idstatus = :status, updated_at = NOW(), deleted_at = NULL WHERE idlang = :id", $data, false);

        if ($update) { $this->savelog(4, "Se actualizó estado de país con id: {$data['id']}", $_SESSION[USER_SESSION]['id']); }

        return $update;
    }

    //sudo

    public function verify_lancode($lancode)
    {
        return (empty($this->pst("SELECT * FROM tbl_languages WHERE lancode = :lancode", ['lancode' => $lancode]))) ? true : false;
    }

    // sudo
    public function new_language($data)
    {
        $data['lanicon'] = "<i class='flag-icon flag-icon-{$data['lancode']}' mr-2></i>";

        $lang = $this->pst("SELECT lancode FROM tbl_languages WHERE idstatus = 1 ORDER BY idlang DESC LIMIT 1");

        $last_lancode = (!empty($lang)) ? $lang[0]->lancode : false;

        $res = $this->pst("CALL sp_insertlanguage(:language, :lancode, :lanicon)", $data);

        if ($res)
        {
            $idlang = $res[0]->idlanguage;

            $this->savelog(3, "Se insertó un nuevo registro de idioma con id: {$idlang}", $_SESSION[USER_SESSION]['id']);

            if ($last_lancode)
            {
                $last_lang_file = APP.'/config/languages/'.$last_lancode.'.php';

                $new_lang_file = APP.'/config/languages/'.$data['lancode'].'.php';

                if (!copy($last_lang_file, $new_lang_file))
                {
                    $update = $this->pst("UPDATE tbl_languages SET idstatus = 2, updated_at = NOW(), deleted_at = NULL WHERE idlang = :id", [ 'id' => $idlang ], false);
                }
            }
            else
            {
                $file = fopen(APP.'/config/languages/'.$data['lancode'].'.php', 'x');

                if ($file)
                {
                    $update = $this->pst("UPDATE tbl_languages SET idstatus = 2, updated_at = NOW(), deleted_at = NULL WHERE idlang = :id", [ 'id' => $idlang ], false);
                }

                fclose($file);
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

                    $res = $this->pst("UPDATE tbl_languages SET language = :language, lancode = :lancode, lanicon = :lanicon, updated_at = NOW(), deleted_at = NULL WHERE idlang = :id", $data, false);

                    if ($res) { $this->savelog(4, "Se actualizó el registro de idioma con id: {$data['id']}", $_SESSION[USER_SESSION]['id']); }

                    return $res;
                }
                else
                {
                    $data['lanicon'] = "<i class='flag-icon flag-icon-{$data['lancode']}' mr-2></i>";

                    $res = $this->pst("UPDATE tbl_languages SET language = :language, lancode = :lancode, lanicon = :lanicon, updated_at = NOW(), deleted_at = NULL WHERE idlang = :id", $data, false);

                    if ($res) { $this->savelog(4, "Se actualizó el registro de idioma con id: {$data['id']}", $_SESSION[USER_SESSION]['id']); }

                    if (!file_exists($new_lang_file))
                    {
                        if (!copy($lang_file, $new_lang_file))
                        {
                            $this->pst("UPDATE tbl_languages SET idstatus = 2, updated_at = NOW(), deleted_at = NULL WHERE idlang = :id", [ 'id' => $data['id'] ], false);
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
        $res = $this->pst("UPDATE tbl_languages SET idstatus = 11, deleted_at = NOW() WHERE idlang = :id", $data, false);

        if ($res) { $this->savelog(5, "Se eliminó el registro de idioma con id: {$data['id']}", $_SESSION[USER_SESSION]['id']); }

        return $res;
    }

    #--------------------------------------------------
    // CRUD tbl_actions
    #--------------------------------------------------

    // all levels
    public function action_list()
    {
        $res = $this->pst("SELECT * FROM v_actions");

        if (!empty($res))
        {
            $data = [];

            foreach ($res as $val)
            {
                $data['idaction'][] = $val->idaction;
                $data['action'][] = $val->action;
                $data['btbadge'][] = $val->btbadge;
                $data['showfield'][] = $val->showfield;
                $data['created_at'][] = $val->created_at;
            }

            return $data;
        }
        else
        {
            return false;
        }
    }

    // all levels
    public function info_action($idaction)
    {
        $res = $this->pst("SELECT * FROM v_actions WHERE idaction = :id", ['id' => $idaction]);

        if (!empty($res))
        {
            $data = [];

            foreach ($res as $val)
            {
                $data['idaction'][] = $val->idaction;
                $data['action'][] = $val->action;
                $data['btbadge'][] = $val->btbadge;
                $data['showfield'][] = $val->showfield;
                $data['created_at'][] = $val->created_at;
            }

            return $data;
        }
        else
        {
            return false;
        }
    }

    // sudo
    public function new_action($data)
    {
        $res = $this->pst("CALL sp_insertaction(:action, :btbadge)", $data);

        if ($res) {
            $this->savelog(3, "Se insertó un nuevo registro de action con id: {$res[0]->idaction}", $_SESSION[USER_SESSION]['id']);
        }

        return $res;
    }

    // sudo
    public function edit_action($data)
    {
        $res = $this->pst("UPDATE tbl_actions SET action = :action, btbadge = :btbadge WHERE idaction = :id", $data, false);

        if ($res) { $this->savelog(4, "Se actualizó el registro de acción con id: {$data['id']}", $_SESSION[USER_SESSION]['id']); }

        return $res;
    }

    // sudo
    public function show_action($data)
    {
        $res = $this->pst("SELECT showfield FROM tbl_actions WHERE idaction = :id", $data);

        $data['showfield'] = ($res[0]->showfield == 2) ? 1 : 2;

        $update = $this->pst("UPDATE tbl_actions SET showfield = :showfield WHERE idaction = :id", $data, false);

        if ($update) { $this->savelog(4, "Se actualizó el showfield de la acción con id: {$data['id']}", $_SESSION[USER_SESSION]['id']); }

        return $update;
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
    public function recover_password($pass)
    {
        $data = $this->pst("SELECT iduser FROM tbl_users WHERE token = :token", ['token' => $_SESSION['token']]);

        if (!empty($data))
        {
            $arr_data = [
                'pass' => $pass,
                'iduser' => $data[0]->iduser
            ];

            $query = "UPDATE tbl_users SET pass = :pass, token = NULL, tokendate = NULL, forgetpass = 0, registermail = 0, idstatus = 1, updated_at = NOW() WHERE iduser = :iduser";

            $res = $this->pst($query, $arr_data, false);

            if ($_SESSION['gestion'] == 'confirm' || $_SESSION['gestion'] == 'firstIn')
            {
                $this->savelog(1, 'Registro de usuario desde formulario', $arr_data['iduser']);
                $this->session_log($arr_data['iduser'], 'in');
            }
            else
            {
                $this->savelog(4, 'Restablecimiento de contraseña', $arr_data['iduser']);
            }

            return $res;
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
        if (!isset($_SESSION['val']))
        {
            $res = $this->pst("UPDATE tbl_users SET pass = :pass, updated_at = NOW() WHERE iduser = :iduser", $arr_data, false);
        }
        else
        {
            $centinel = true;

            while ($centinel)
            {
                $token = password_hash($this->getKey(70), PASSWORD_DEFAULT, ['cost' => 10]);

                if (!$this->token_validator($token))
                {
                    $centinel = false;
                    break;
                }
            }

            $arr_data['token'] = $token;

            $res = $this->pst("UPDATE tbl_users SET pass = :pass, token = :token, tokendate = NOW(), idstatus = 3, updated_at = NOW(), forgetpass = 1 WHERE iduser = :iduser", $arr_data, false);
        }

        if ($res)
        {
            if (!isset($_SESSION['val'])) {
                $this->savelog(4, 'Se actualizó la contraseña de acceso', $arr_data['iduser']);
            }else {
                $this->savelog(4, "Se actualizó la contraseña de acceso del usuario con id: {$arr_data['iduser']}", $_SESSION[USER_SESSION]['id']);
            }
        }

        return $res;
    }

    #--------------------------------------------------
    // Tokens
    #--------------------------------------------------

	// principal
    public function set_reset_token($email, $token)
	{
        $arr_data = [
            'token' => $token,
            'email' => $email,
            'id' => 1
        ];

		$res = $this->pst("UPDATE tbl_users SET token = :token, tokendate = NOW(), updated_at = NOW() WHERE email = :email AND idstatus = :id", $arr_data, false);

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
    public function savelog($idaction, $description, $iduser)
    {
        $arr_data = [
            'idaction' => $idaction,
            'description' => $description,
            'iduser' => $iduser
        ];

        $this->pst("INSERT INTO tbl_logs VALUES (NULL, :description, :idaction, :iduser, NOW())", $arr_data, false);
    }

    public function session_log($iduser, $type)
    {
        $input_data = [ 'id' => $iduser, 'addr' => $_SERVER['REMOTE_ADDR'] ];

        switch ($type) {
            case 'in':
                $this->pst("INSERT INTO tbl_inputs VALUES (NULL, :addr, :id, NOW())", $input_data, false);
            break;

            case 'out':
                $this->pst("INSERT INTO tbl_outputs VALUES (NULL, :addr, :id, NOW())", $input_data, false);
            break;
        }

    }

    // all levels
    public function register_mail($email, $token)
    {
        $arr_data = [
            'token' => $token,
            'email' => $email
        ];

        $query = "UPDATE tbl_users SET token = :token, tokendate = NOW(), registermail = 1, idstatus = 1 WHERE email = :email";

        return $this->pst($query, $arr_data, false);
    }

    // principal
    public function forgetpass_mail($email, $token)
    {
        $arr_data = [
            'token' => $token,
            'email' => $email
        ];

        $query = "UPDATE tbl_users SET token = :token, tokendate = NOW(), forgetpass = 1, idstatus = 1 WHERE email = :email";

        $res = $this->pst($query, $arr_data, false);

        if ($res)
        {
            $data = $this->is_correct_mail($email);

            $this->savelog(4, "Solicitud de restablecimiento de contraseña", $data['iduser']);
        }

        return $res;
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
        $query = "SELECT s.subject, s.mssg, s.response, s.idstatus, e.btbadge FROM tbl_supports s INNER JOIN tbl_status e ON s.idstatus = e.idstatus WHERE iduser = :iduser";

        $res = $this->pst($query, ['iduser' => $iduser]);

        if (!empty($res))
        {
            $list = [];

            foreach ($res as $val)
            {
                $list['user'][] = $_SESSION[USER_SESSION]['email'];
                $list['subject'][] = $val->subject;
                $list['mssg'][] = $val->mssg;
                $list['response'][] = (is_null($val->response)) ? '' : $val->response;
                $list['idstatus'][] = $val->idstatus;
                $list['btbadge'][] = $val->btbadge;
            }

            return $list;
        }
        else
        {
            return 'empty';
        }
    }
}