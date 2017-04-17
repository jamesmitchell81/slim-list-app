<?php

namespace App\Controllers;

use Slim\Views\PhpRenderer as View;
use Psr\Log\LoggerInterface;

use App\Persistence\Database;
use \PDO;

class ListController
{
	private $view;
	private $logger;
	private $db;
	private $connection;

	public function __construct(View $view, LoggerInterface $logger, Database $db)
	{
		$this->view = $view;
		$this->logger = $logger;
		$this->db = $db;
	}

	public function display($request, $response, $args)
	{
		$this->logger->info("User xx displayed lists");

		// TEMP: session get user.
		$user_id = $_SESSION['user_id'];

		// $user = new User($user_id);
		//

		$this->connection = $this->db->connection();
		$SQL = "SELECT * FROM app_lists WHERE user_id = :user_id";
		$statement = $this->connection->prepare($SQL);
		$statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$statement->execute();
		$args['lists'] = $statement->fetchAll(PDO::FETCH_ASSOC);

		return $this->view->render($response, 'lists.phtml', $args);
	}
}