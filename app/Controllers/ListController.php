<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig as View;
use Psr\Log\LoggerInterface;

use App\Repository\ListRepository;
use App\Repository\UserRepository;
use App\Persistence\Database;
use App\Entity\AppList;

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

	public function display(Request $request, Response $response, $args)
	{
		// TEMP: session get user.
        $user_id = $_SESSION['user_id'];

		$users = new UserRepository($this->db);
		$user = $users->find($user_id);

		$lists = (new ListRepository($this->db))
                    ->findByUser($user_id)
                    ->all();

		$user->setLists($lists);

		$args['user'] = $user;
		$args['name'] = "James";

		return $this->view->render($response, 'lists.html.twig', $args);
	}

	// Add an list to a user
	public function add(Request $request, Response $response)
	{
		$body = $request->getParsedBody();

		$users = new UserRepository($this->db);
		$user = $users->find($_SESSION['user_id']);

		$list = new AppList();
		$list->setUser($user);
		$list->setListName($body['list_name']);

		$lists = new ListRepository($this->db);
		$list = $lists->add($list);

		return $response->withRedirect('/lists/' . $list->getId());
	}
}