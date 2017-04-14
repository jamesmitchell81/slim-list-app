<?php

$app->get('/', 'App\Controllers\HomeController:home');

$app->get('/lists', 'App\Controllers\ListController:display');
$app->get('/list/{list_id}', 'App\Controllers\ListItemController:display');

$app->get('/item/{item_id}/edit', 'App\Controllers\ListItemController:displayEdit');
$app->post('/item/{item_id}/edit', 'App\Controllers\ListItemController:edit');