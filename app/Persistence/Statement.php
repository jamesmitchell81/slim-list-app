<?php

namespace App\Persistence;

use \PDO;

class Statement
{
	private $db;
	private $statement;
	private $connection;

	private $fetchType = PDO::FETCH_ASSOC;

	public function __construct(Database $db)
	{
		$this->db = $db;
	}

	public function prepare(string $SQL)
	{
		$this->connection = $this->db->connection();
		$this->statement = $this->connection->prepare($SQL);
		return $this;
	}

	public function bind(array $params)
	{
		if ( !$this->statement ) return $this;

		foreach($params as $key => &$value)
		{
			$this->statement->bindParam(":{$key}", $value);
		}

		return $this;
	}

	public function bindInt()
	{

	}

	public function execute()
    {
        return $this->statement->execute();
    }

    public function getLastInsertId() : int
    {
        return $this->connection->lastInsertId();
    }

	public function fetch()
	{
		$this->statement->execute();
		return $this->statement->fetch($this->fetchType);
	}

	public function fetchAll()
	{
		$this->statement->execute();
		return $this->statement->fetchAll($this->fetchType);
	}
}

