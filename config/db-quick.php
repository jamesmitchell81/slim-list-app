<?php

/**
 * Temporary!!!
 * Replace with symfony/console.
 */

require __DIR__.'/../vendor/autoload.php';

// use App\Persistence\PdoDatabase as Database;
$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

function db()
{
	return new App\Persistence\PdoDatabase(
			getenv('DB_DRIVER'),
			getenv('DB_HOST'),
			getenv('DB_PORT'),
			getenv('DB_NAME'),
			getenv('DB_USERNAME'),
			getenv('DB_PASSWORD')
		);
}

function create_tables() {
	$filename = __DIR__.'/sql/create-tables.sql';
	$pattern = "/^CREATE\sTABLE\s`([a-z_]+)`/";

	$sql = file($filename);
	$statements = [];

	for ($i = 0; $i < count($sql); $i++) {
		$line = $sql[$i];
		$matches = [];
		if ( preg_match($pattern, $line, $matches) )
		{
			$table_name = $matches[1];
			$table[$table_name] = [];
			while ( !preg_match("/\);$/", $sql[$i]) )
			{
				$line = $sql[$i];
				$table[$table_name][] = $line;
				$i++;
			}
			$table[$table_name][] = ");";
			$statements[$table_name] = join($table[$table_name]);
		}
	}

	$connection = db()->connection();

	foreach ($statements as $statement) {
		$connection->exec($statement);
	}
}

function drop_tables()
{
	$filename = __DIR__.'/sql/drop-tables.sql';
	$pattern = "/^DROP\sTABLE\s`([a-z_]+)`;/";

	$sql = file($filename);
	$statements = [];

	for ($i = 0; $i < count($sql); $i++) {
		$line = $sql[$i];
		$matches = [];
		if ( preg_match($pattern, $line, $matches) )
		{
			$table_name = $matches[1];
			$table[$table_name] = [];
			$table[$table_name][] = $line;
			$statements[$table_name] = join($table[$table_name]);
		}
	}

	$connection = db()->connection();

	foreach ($statements as $statement) {
		$connection->exec($statement);
	}
}

function fake()
{
	$faker = Faker\Factory::create();
	$connection = db()->connection();
	// 10 users
	$SQL = "INSERT INTO app_users (username, email_address, password) VALUES (:username, :email_address, :password)";
	$statement = $connection->prepare($SQL);
	for ( $i = 0; $i < 10; $i++ )
	{
		$user = $faker->userName;
		$email = $faker->safeEmail;
		$password = $faker->password;
		$statement->bindParam(':username', $user, PDO::PARAM_STR);
		$statement->bindParam(':email_address', $email, PDO::PARAM_STR);
		$statement->bindParam(':password', $password, PDO::PARAM_STR);
		$statement->execute();
	}

	// Get user ids.
	$SQL = "SELECT id FROM app_users";
	$statement = $connection->prepare($SQL);
	$statement->execute();
	$users = $statement->fetchAll(PDO::FETCH_ASSOC);

	// each with 10 lists
	$SQL = "INSERT INTO app_lists (list_name, description, user_id) VALUES (:list_name, :description, :user_id)";
	$statement = $connection->prepare($SQL);
	foreach ( $users as $user )
	{
		for ($i = 0; $i < 10; $i++ )
		{
			$name = $faker->text(30);
			$description = $faker->text(200);
			$statement->bindParam(':list_name', $name, PDO::PARAM_STR);
			$statement->bindParam(':description', $description, PDO::PARAM_STR);
			$statement->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
			$statement->execute();
		}
	}

	// get the list ids.
	$SQL = "SELECT id FROM app_lists";
	$statement = $connection->prepare($SQL);
	$statement->execute();
	$lists = $statement->fetchAll(PDO::FETCH_ASSOC);

	// each with 10 items.
	$SQL = "INSERT INTO app_list_items (value, list_id) VALUES (:value, :list_id)";
	$statement = $connection->prepare($SQL);
	foreach ( $lists as $list )
	{
		for ( $i = 0; $i < 10; $i++ )
		{
			$val = $faker->text(50);
			$statement->bindParam(':value', $val, PDO::PARAM_STR);
			$statement->bindParam(':list_id', $list['id'], PDO::PARAM_INT);
			$statement->execute();
		}
	}
	echo gettype($faker->text(30));
}


if ( $argv[1] == "--create")
{
	create_tables();
}
else if ( $argv[1] == "--drop" )
{
	drop_tables();
}
else if ( $argv[1] == "--fake" )
{
	fake();
}

