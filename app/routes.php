<?php

$app->get('/', 'App\Controllers\HomeController:home');

$app->get('/lists', 'App\Controllers\ListController:display'); // HomeController?
$app->post('/lists', 'App\Controllers\ListController:add');

$app->get('/lists/{list_id}', 'App\Controllers\ListItemController:display');
$app->post('/lists/{list_id}', 'App\Controllers\ListItemController:add');

$app->get('/lists/{list_id}/items/{item_id}', 'App\Controllers\ListItemController:item');
$app->post('/lists/{list_id}/items/{item_id}', 'App\Controllers\ListItemController:edit');

// $app->put('/lists/{list_id}/items/{item_id}', 'App\Controllers\ListItemController:edit');
// $app->patch('/lists/{list_id}/items/{item_id}', 'App\Controllers\ListItemController:edit');

$app->get('/lists/{list_id}/items/{item_id}/delete', 'App\Controllers\ListItemController:delete');
// $app->delete('/lists/{list_id}/items/{item_id}', 'App\Controllers\ListItemController:delete');

$app->get('lists/{list_id}/items/{item_id}/activate', 'App\Controllers\ListItemController:activate'); // x
$app->get('lists/{list_id}/items/{item_id}/deactivate', 'App\Controllers\ListItemController:deactivate'); // x

// $app->get('/item/{item_id}/toggle', 'App\Controllers\ListItemController:toggle');
$app->get('/lists/{list_id}/items/{item_id}/complete', 'App\Controllers\ListItemController:complete');