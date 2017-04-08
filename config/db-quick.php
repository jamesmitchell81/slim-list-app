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
	// 10 users

	// each with 10 lists

	// each with 10 items.
}

if ( $argv[1] == "--create")
{
	create_tables();
}
else if ( $argv[1] == "--drop" )
{
	drop_tables();
}
else is ( $argv[1] == "--fake" )
{
	fake();
}

