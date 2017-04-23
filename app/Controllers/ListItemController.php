<?php

namespace App\Controllers;

use App\Repository\ListItemRepository;
use Slim\Views\PhpRenderer as View;
use Psr\Log\LoggerInterface;

use App\Entity\ListItem;
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
		// display ... list with all list items.
		$user_id = $_SESSION['user_id'];
		$list_id = $args['list_id'];

		$list = (new ListRepository($this->db))->findBy(
		    [
		        'id' => $list_id,
                'user_id' => $user_id
            ]
        )->first();


        $items = (new ListItemRepository($this->db))->findByList($list->getId())->all();
		$list->setItems($items);

		$args['list'] = $list;

		return $this->view->render($response, 'list.phtml', $args);
	}

	public function add($request, $response, $args)
	{
		$list_id = $args['list_id'];
		$user_id = $_SESSION['user_id'];

		$body = $request->getParsedBody();
		// TODO: VALIDATE NEW ITEM BODY!
		$value = $body['new-item'];

		$list = (new ListRepository($this->db))->findBy(
		    [
		        'id' => $list_id,
                'user_id' => $user_id
            ]
        )->first();

        $item = new ListItem();
        $item->setValue($value);
        $item->setList($list);

        $items = new ListItemRepository($this->db);
        $items->add($item);

		return $response->withRedirect('/list/' . $list->getId());
	}

	public function displayEdit($request, $response, $args)
	{
		$item_id = $args['item_id'];
        $args['item'] = (new ListItemRepository($this->db))->find($item_id);

		return $this->view->render($response, 'list-item-edit.phtml', $args);
	}

	public function edit($request, $response, $args)
	{
		$body = $request->getParsedBody();
		$item_id = $args['item_id'];

		// TODO: VALIDATE!
		$item_value = $body['item_value'];

        $items = new ListItemRepository($this->db);

        $item = $items->find($item_id);
        $item->setValue($item_value);

		$items->update($item);

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

	public function activate($request, $response, $args)
	{
		$item_id = $args['item_id'];

		// $item = new Item();
		// $item->find($item_id);
		// $item->active = true;
		// $item->save();

		$SQL = "UPDATE app_list_items SET active = true WHERE id = :item_id";
		$connection = $this->db->connection();
		$statement = $connection->prepare($SQL);
		$statement->bindParam(':item_id', $item_id, PDO::PARAM_INT);
		$statement->execute();

		// return $response->withRedirect('/list/' . $item->listId);
	}

	public function deactivate($request, $response, $args)
	{
		$item_id = $args['item_id'];

		$SQL = "UPDATE app_list_items SET active = false WHERE id = :item_id";
		$connection = $this->db->connection();
		$statement = $connection->prepare($SQL);
		$statement->bindParam(':item_id', $item_id, PDO::PARAM_INT);
		$statement->execute();

		return $response->withRedirect('/list/1');
	}
}