<?php

namespace App\Tests\Persistence;

use PHPUnit\Framework\TestCase;
use App\Persistence\PdoDatabase;

class SQLQueryTest extends TestCase
{

	private $database;

	public function setUp()
	{
		$dotenv = new \Dotenv\Dotenv(__DIR__.'/../../../');
		$dotenv->load();
		$this->database = new PdoDatabase(
				getenv('DB_DRIVER'),
				getenv('DB_HOST'),
				getenv('DB_PORT'),
				getenv('DB_NAME'),
				getenv('DB_USERNAME'),
				getenv('DB_PASSWORD')
			);
	}

	public function testSimpleSelectStatement()
	{
		$match = "SELECT username, email_address FROM app_users";
		$query = new SQLQuery($this->database);

		$sql = $query->select(['username', 'email_address'])
					 ->from('app_users')
					 ->make();
	}
}






