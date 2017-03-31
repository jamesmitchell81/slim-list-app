<?php
// From Slim-Skeleton
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__.'/../vendor/autoload.php';

session_start();

$settings = require __DIR__.'/../app/settings.php';
$app = new Slim\App($settings);

require __DIR__.'/../app/dependencies.php';

// require middleware.

require __DIR__.'/../app/routes.php';

$app->run();

