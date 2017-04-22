<?php

namespace App\Repository;

use App\Persistence\Database;
use App\Persistence\Statement;

use App\Entity\User;

class UserRepository
{

	private $db;

	public function __construct(Database $db)
	{
		$this->db = $db;
	}

	public function find(int $id)
	{
		$SQL = "SELECT * FROM app_users WHERE id = :user_id";
		$statement = new Statement($this->db);
		$query = $statement->prepare($SQL)->bind([ 'user_id' => $id ])->fetch();

		$user = new User();
		$user->setId($query['id']);
		$user->setEmailAddress($query['email_address']);
		$user->setCreated($query['created']);
		$user->setUpdated($query['updated']);

		// lists
		return $user;
	}

}