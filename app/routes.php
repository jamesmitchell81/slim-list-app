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
