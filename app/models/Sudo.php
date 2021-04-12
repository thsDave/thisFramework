<?php

require_once 'Model.php';

class Sudo extends Model
{
	public function lvlist()
	{
		$level = [];
		$res = parent::sql("SELECT * FROM tbl_levels;");
		if ($res->num_rows > 0)
		{
			while ($data = $res->fetch_assoc())
			{
			    $level['id'][] = $data['idlvl'];
                $level['level'][] = $data['level'];
			}

			return $level;
		}
		else
		{
			return false;
		}
	}

	public function updateuser($data)
	{
		unset($_SESSION['updateInfoUser']);

		$id = $_SESSION['val'];
		$name = $data[0];
		$position = $data[1];
		$level = $data[2];
		$state = $data[3];

		$res1 = parent::sql("call sp_updtuser('{$name}', '{$position}', {$id})");
		$res2 = parent::sql("UPDATE tbl_users SET idlvl = {$level} WHERE iduser = {$id}");
		$res3 = parent::sql("UPDATE tbl_users SET idstate = {$state} WHERE iduser = {$id}");

		if ($res1 && $res2 && $res3) {
			return true;
		}else {
			return false;
		}
	}

	public function deleteuser($id)
    {
        return parent::sql("DELETE FROM tbl_users WHERE iduser = {$id}");
    }

    public function supportlist()
    {
        $request = [];
        $res = parent::sql("call sp_supportlist();");
        if ($res->num_rows > 0)
        {
            while ($data = $res->fetch_assoc())
            {
                $request['idsupport'][] = $data['idsupport'];
                $request['name'][] = $data['name'];
                $request['email'][] = $data['email'];
                $request['position'][] = $data['position'];
                $request['level'][] = $data['level'];
                $request['subject'][] = $data['subject'];
                $request['idstate'][] = $data['idstate'];
                $request['state'][] = $data['state'];
            }

            return $request;
        }
        else
        {
            return false;
        }
    }

    public function getsupportreq($id)
    {
    	$info = [];
    	$res = parent::sql("call sp_getsupportreq({$id})");
    	if ($res->num_rows > 0)
        {
            while ($data = $res->fetch_assoc())
            {
                $info['idsupport'] = $data['idsupport'];
                $info['name'] = $data['name'];
                $info['subject'] = $data['subject'];
                $info['mssg'] = $data['mssg'];
                $info['response'] = $data['response'];
            }

            return $info;
        }
        else
        {
            return false;
        }
    }

    public function savesupportres($id, $response)
    {
    	return parent::sql("call sp_savesupportres({$id}, '{$response}')");
    }
}