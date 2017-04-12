<?php

// $app->get('/[{name}]', function ($request, $response, $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");

//     // Render index view
//     return $this->renderer->render($response, 'index.phtml', $args);
// });


$app->get('/', 'App\Controllers\HomeController:home');
// $app->get('/lists', 'App\Controllers\ListController:display');

$app->get('/lists', function($request, $response, $args) {
	$db = $this->database->connection();

	$user_id = $_SESSION['user_id'];
	$SQL = "SELECT * FROM app_lists WHERE user_id = :user_id";

	$statement = $db->prepare($SQL);
	$statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
	$statement->execute();
	$lists = $statement->fetchAll(PDO::FETCH_ASSOC);
	$args['lists'] = $lists;

	return $this->renderer->render($response, 'lists.phtml', $args);
});

$app->get('/list/{list_id}', function($request, $response, $args) {
	$db = $this->database->connection();

	// Auth.
	$user_id = $_SESSION['user_id'];
	$list_id = $args['list_id'];

	$SQL = "SELECT i.id, l.list_name, l.description, i.value, i.created, i.updated
			FROM app_list_items AS i
			INNER JOIN app_lists AS l ON i.list_id = l.id
			WHERE l.user_id = :user_id AND i.list_id = :list_id
			ORDER BY i.created DESC";

	$statement = $db->prepare($SQL);
	$statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
	$statement->bindParam(':list_id', $list_id, PDO::PARAM_INT);
	$statement->execute();
	$items = $statement->fetchAll(PDO::FETCH_ASSOC);
	$args['items'] = $items;

	return $this->renderer->render($response, 'list.phtml', $args);
});
