<?php

// $app->get('/[{name}]', function ($request, $response, $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");

//     // Render index view
//     return $this->renderer->render($response, 'index.phtml', $args);
// });


$app->get('/', 'App\Controllers\HomeController:home');
$app->get('/lists', 'App\Controllers\ListController:display');
