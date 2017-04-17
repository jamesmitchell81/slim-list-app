<?php

$app->get('/', 'App\Controllers\HomeController:home');

$app->get('/lists', 'App\Controllers\ListController:display');
$app->get('/list/{list_id}', 'App\Controllers\ListItemController:display');

$app->post('/list/{list_id}/add', 'App\Controllers\ListItemController:add');

$app->get('/item/{item_id}/edit', 'App\Controllers\ListItemController:displayEdit');

$app->post('/item/{item_id}/edit', 'App\Controllers\ListItemController:edit');
// $app->put('/item/{item_id}', 'App\Controllers\ListItemController:edit');

$app->get('/item/{item_id}/delete', 'App\Controllers\ListItemController:delete');
// $app->delete('/item/{item_id}', 'App\Controllers\ListItemController:delete');

$app->get('/item/{item_id}/complete', 'App\Controllers\ListItemController:complete');

