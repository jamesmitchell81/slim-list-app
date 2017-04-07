<?php

namespace App\Persistence;

class PdoDatabase implements Database
{

	private $driver;
	private $host;
	private $dbname;
	private $username;
	private $password;

	private $connection;

	public function __construct($driver, $host, $dbname, $username, $password)
	{
		$this->driver = $driver;
		$this->host = $host;
		$this->dbname = $dbname;
		$this->username = $username;
		$this->password;
	}

	private function connect()
	{
		$datasource = "$this->driver:host=$this->host;dbname=$this->dbname;charset=utf8";
		$options = [];
		try {
			$pdo = new PDO($datasource, $this->username, $this->password);
		} catch (PDOException $e) {
			echo "Connection failed" . $e->getMessage();
		}
		// PDO etc...
	}

	public function connection()
	{
		// if not connection
		$this->connection = $this->connect();
		return $this->connection;
	}

	public function close() {}


	public function getHost()
	{
		return $this->host;
	}

	public function getDatabaseName()
	{
		return $this->dbname;
	}
}