<?php

	require_once 'config.php';

	class Conection
	{
	    public $host;
	    public $user;
	    public $pwd;
	    public $bd;
	    public $con;

	    public function __construct()
	    {
	    	$this->host = DB_HOST;
	    	$this->user = DB_USER;
	    	$this->pwd = DB_PWD;
	    	$this->db = DB_NAME;
	    }

	    public function conectar()
	    {
	    	try
	    	{
	    		$this->con = mysqli_connect($this->host, $this->user, $this->pwd, $this->db);

	    		if ($this->con)
	    			return $this->con;
	    		else
	    			throw new Exception('No fue posible conectarse a la base de datos');
	    	}
	    	catch (Exception $e)
	    	{
	    		load_view('db_err');
	    	}
	    }

	    public function desconectar()
	    {
	    	try
	    	{
	    		if (!mysqli_close($this->con))
	    			throw new Exception('No fue posible conectarse a la base de datos');

	    	}
	    	catch (Exception $e)
	    	{
	    		load_view('db_err');
	    	}
	    }
	}