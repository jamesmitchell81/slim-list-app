<?php require 'vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$settings = include 'app/settings.php';
$isDev = true;
$paths = [
	__DIR__.'/config/yaml/'
];

$settings = $settings['settings']['doctrine'];
$connection = $settings['database'];
$config = Doctrine\ORM\Tools\Setup::createYAMLMetadataConfiguration(
		$paths,
		$isDev,
		__DIR__.'/cache/proxies/'
	);
$em = Doctrine\ORM\EntityManager::create($connection, $config);
return ConsoleRunner::createHelperSet($em);
