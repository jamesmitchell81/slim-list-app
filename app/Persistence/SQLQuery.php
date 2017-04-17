<?php

namespace App\Persistence;

class SQLQuery implements Query
{
	private $database;
	private $query = "";
	private $table;
	private $columns = [];
	private $statement;

	// SELECT columns FROM table WHERE key = value

	public function __construct(Database $db)
	{
		$this->database = $db;
	}

	private function makeSelect()
	{
		$select[0] = "SELECT";
		$select[1] = $this->columns;
		$select[2] = "FROM";
		$select[3] = $this->table;

		// array_merge_recusive() ??
	}

	public function select(array $columns)
	{
		$this->columns = $columns;
		return $this;
	}

	public function from($table)
	{
		$this->table = $table;
		return $this;
	}

	public function where(array $conditions)
	{
		$this->conditions = $conditions;
		return $this;
	}

}