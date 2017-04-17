<?php

namespace App\Controllers;

use Slim\Views\PhpRenderer as View;
use Psr\Log\LoggerInterface;

use App\Persistence\Database;
use App\Repository\ListRepository;
use \PDO;

class ListItemController
{

	private $view;
	private $logger;
	private $db;

	public function __construct(View $view, LoggerInterface $logger, Database $db)
	{
		$this->view = $view;
		$this->logger = $logger;
		$this->db = $db;
	}

	public function display($request, $response, $args)
	{
		$user_id = $_SESSION['user_id'];
		$list_id = $args['list_id'];

		$SQL = "SELECT i.id, l.list_name, l.description, i.value, i.created, i.updated
				FROM app_list_items AS i
				INNER JOIN app_lists AS l ON i.list_id = l.id
				WHERE l.user_id = :user_id AND i.list_id = :list_id
				AND i.deleted = false
				ORDER BY i.created DESC";

		$connection = $this->db->connection();
		$statement = $connection->prepare($SQL);
		$statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$statement->bindParam(':list_id', $list_id, PDO::PARAM_INT);
		$statement->execute();
		$args['items'] = $statement->fetchAll(PDO::FETCH_ASSOC);

		return $this->view->render($response, 'list.phtml', $args);
	}

	public function add($request, $response, $args)
	{
		$list_id = $args['list_id'];
		$repo = new ListRepository($this->db);
		$list = $repo->find($list_id);

		return $response->withRedirect('/list/' . $list->getId());
	}

	public function displayEdit($request, $response, $args)
	{
		$user_id = $_SESSION['user_id'];
		$item_id = $args['item_id'];

		$SQL = "SELECT i.id, i.value, i.complete, i.deleted,
					   l.list_name, l.description, i.list_id
				FROM app_list_items AS i
				INNER JOIN app_lists as l ON l.id = i.list_id
				WHERE i.id = :item_id AND l.user_id = :user_id";

		$connection = $this->db->connection();
		$statement = $connection->prepare($SQL);
		$statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$statement->bindParam(':item_id', $item_id, PDO::PARAM_INT);
		$statement->execute();
		$args['item'] = $statement->fetch(PDO::FETCH_ASSOC);

		return $this->view->render($response, 'list-item-edit.phtml', $args);
	}

	public function edit($request, $response, $args)
	{
		$body = $request->getParsedBody();
		$item_id = $args['item_id'];
		$item_value = $body['item_value'];

		$item = (new ListItem)->find($item_id);
		$item->setValue($item_value);
		$item->save();

		$SQL = "UPDATE app_list_items SET value = :value WHERE id = :item_id";
		$connection = $this->db->connection();
		$statement = $connection->prepare($SQL);
		$statement->bindParam(':value', $item_value, PDO::PARAM_STR);
		$statement->bindParam(':item_id', $item_id, PDO::PARAM_INT);
		$statement->execute();


		return $response->withRedirect('/list/' . $item->getList()->getId());
	}

	// Soft Delete.
	public function delete($request, $response, $args)
	{
		$item_id = $args['item_id'];

		// $SQL = "DELETE FROM app_list_items WHERE id = :list_id";
		$SQL = "UPDATE app_list_items SET deleted = true WHERE id = :item_id";
		$connection = $this->db->connection();
		$statement = $connection->prepare($SQL);
		$statement->bindParam(':item_id', $item_id, PDO::PARAM_INT);
		$statement->execute();

		// get the list id in order to return after edit.
		$SQL = "SELECT list_id FROM app_list_items WHERE id = :item_id";
		$statement = $connection->prepare($SQL);
		$statement->bindParam(':item_id', $item_id, PDO::PARAM_INT);
		$statement->execute();
		$list = $statement->fetch(PDO::FETCH_ASSOC);

		return $response->withRedirect('/list/' . $list['list_id']);
	}

	public function complete($request, $response, $args)
	{
		$item_id = $args['item_id'];

		$SQL = "UPDATE app_list_items SET complete = true WHERE id = :item_id";
		$connection = $this->db->connection();
		$statement = $connection->prepare($SQL);
		$statement->bindParam(':item_id', $item_id, PDO::PARAM_INT);
		$statement->execute();

		$SQL = "SELECT list_id FROM app_list_items WHERE id = :item_id";
		$statement = $connection->prepare($SQL);
		$statement->bindParam(':item_id', $item_id, PDO::FETCH_ASSOC);
		$statement->execute();
		$list = $statement->fetch(PDO::FETCH_ASSOC);

		return $response->withRedirect('/list/' . $list['list_id']);
	}
}