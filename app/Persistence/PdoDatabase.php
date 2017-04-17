<?php

namespace App\Persistence;

use \PDO;

class PdoDatabase implements Database
{

	private $driver;
	private $host;
	private $port;
	private $dbname;
	private $username;
	private $password;

	private $connection;

	public function __construct($driver, $host, $port, $dbname, $username, $password)
	{
		$this->driver = $driver;
		$this->host = $host;
		$this->port = $port;
		$this->dbname = $dbname;
		$this->username = $username;
		$this->password = $password;
	}

	private function connect()
	{
		$datasource = "{$this->driver}:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8";
		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		];

		try {
			return new PDO($datasource, $this->username, $this->password, $options);
		} catch (PDOException $e) {
			echo "Connection failed" . $e->getMessage();
			exit();
		}
	}

	public function connection()
	{
		// if not connection
		if ( !$this->connection )
		{
			$this->connection = $this->connect();
		}
		return $this->connection;
	}

	public function close()
	{
		$this->connection = null;
	}

	public function prepare(array $data) {}
	public function query() {}
	public function execute() {}
}