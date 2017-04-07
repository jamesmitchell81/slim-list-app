<?php

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// $container['em'] = function($c) {
// 	$settings = $c->get('settings')['doctrine'];
// 	$isDev = true;
// 	$paths = [
// 		__DIR__.'/../config/yaml'
// 	];
// 	$connection = $settings['database'];
// 	$config = Doctrine\ORM\Tools\Setup::createYAMLMetadataConfiguration(
// 			$paths,
// 			$isDev
// 		);
// 	return Doctrine\ORM\EntityManager::create($connection, $config);
// };

$container['database'] = function($cont)
{
	$settings = $c->get('settings')['database'];
	return App\Persistence\PdoDatabase(
			$settings['host'],
			$settings['dbname'],
			$settings['user'],
			$settings['password']
		);
};

/* Controller/Action Factory. */
$container['App\Controllers\HomeController'] = function($cont) {
	return new App\Controllers\HomeController(
			$cont->get('renderer'),
			$cont->get('logger')
		);
};

$container['App\Controllers\ListController'] = function($cont) {
	return new App\Controllers\ListController(
			$cont->get('renderer'),
			$cont->get('logger'),
			$cont->get('em')
		);
};
