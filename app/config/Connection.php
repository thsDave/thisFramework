<?php

	require_once 'config.php';

	class Connection
	{
		private $dbms;
	    private $host;
    	private $user;
    	private $pwd;
    	private $db;
    	private $port;
    	private $socket;
    	private $charset;
	    private $con;

	    public function __construct()
	    {
	    	$this->dbms = trim( DBMS );
	    	$this->host = trim( DB_HOST );
	    	$this->user = trim( DB_USER );
	    	$this->pwd = trim( DB_PWD );
	    	$this->db = trim( DB_NAME );
	    	$this->port = trim( DB_PORT );
	    	$this->port = trim( DB_SOCKET );
	    	$this->charset = trim( DB_CHARSET );
	    }

	    public function connect()
	    {
	    	try
	    	{
	    		switch ($this->dbms)
	    		{
	    			case 'MYSQL':
	    				$port = ( empty( $this->port ) ) ? $this->port : "port={$this->port};";
	    				$str_connect = "mysql:host={$this->host}; {$port} dbname={$this->db}; charset={$this->charset}";
	    			break;

	    			case 'SQLSRV':
	    				$sqlsrv = ( empty($this->port) ) ? "server={$this->host}" : "server={$this->host},{$this->port}";
	    				$str_connect = "sqlsrv:{$sqlsrv};database={$this->db}";
	    			break;

	    			case 'ORCL':
	    				$str_connect = ( empty( $this->port ) ) ? "oci:dbname=//{$this->host}/{$this->db}" : "oci:dbname=//{$this->host}:{$this->port}/{$this->db}";
	    			break;

	    			case 'PGSQL':
	    				$str_connect = "pgsql:host={$this->host}; port={$this->port}; dbname={$this->db}; user={$this->user}; password={$this->pwd}";
	    			break;

	    			case 'SOCKET':
	    				$str_connect = "mysql:unix_socket={$this->socket};dbname={$this->db}";
	    			break;
	    		}

	    		$options = [
	    			PDO::ATTR_CASE => PDO::CASE_LOWER,
	    			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    			PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
	    			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
	    		];

	    		$this->con = ($this->dbms != 'PGSQL') ? new PDO($str_connect, $this->user, $this->pwd, $options) : $this->con = new PDO($str_connect, $options);

    			return $this->con;
	    	}
	    	catch (PDOException $e)
	    	{
	    		load_view('db_err', utf8_encode($e->getCode()));
	    	}
	    }

	    public function disconnect()
	    {
	    	$this->con = null;
	    }
	}