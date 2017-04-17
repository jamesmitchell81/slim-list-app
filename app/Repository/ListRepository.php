<?php

namespace App\Repository;

use App\Persistence\Database;
use App\Persistence\Statement;

use App\Entity\User;
use App\Entity\AppList;

use \PDO;

class ListRepository
{
	private $db;

	public function __construct(Database $db)
	{
		$this->db = $db;
		return $this;
	}

	public function find(int $list_id) // : AppList
	{
		$user = (new User)->find($_SESSION['user_id']);

		$SQL = "SELECT * FROM app_lists WHERE id = :list_id AND user_id = :user_id";
		$binds = [
			'user_id' => $user->getId(),
			'list_id' => $list_id
		];
		$statement = new Statement($this->db);
		$query = $statement->prepare($SQL)->bind($binds)->fetch();

		return AppList::from($query);
	}

	public function findBy(array $data) // : AppList
	{

	}

	public function save(AppList $list)
	{

	}
}