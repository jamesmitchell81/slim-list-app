<?php

namespace App\Persistence;

class DatabaseStorage implements Storage
{
	private $database;
	private $connection;

	public function __construct(Database $database)
	{
		$this->database = $database;
		$this->connection = $this->database->connection();
	}

	public function persist(array $data)
	{

	}

	public function retrive(int $id)
	{

	}

	public function delete(int $id)
	{

	}
}