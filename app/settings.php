<?php

$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

return [
	'settings' => [
		'displayErrorDetails' => true,
        'renderer' => [
            'template_path' => __DIR__ . '/templates/',
        ],
		'logger' => [
			'name' => 'slim-list-app',
			'path' => __DIR__.'/../logs/app.log',
			'level'=> \Monolog\Logger::DEBUG
		],
		'database' => [
			'driver' => getenv('DB_DRIVER'),
			'host' => getenv('DB_HOST'),
			'port' => getenv('DB_PORT'),
			'dbname' => getenv('DB_NAME'),
			'user' => getenv('DB_USERNAME'),
			'password' => getenv('DB_PASSWORD')
		]
	]
];