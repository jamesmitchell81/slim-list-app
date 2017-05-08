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

		$repo = new ListRepository($this->db);
		$repo->findByUser($user_id);
		$lists = $repo->sort(['createdTimestamp'])->asc();

		$args['user'] = $user;
		$args['lists'] = $lists;

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
		$list->setListName($body['list-name']);

		$lists = new ListRepository($this->db);
		$list_id = $lists->add($list);

		return $response->withRedirect('/lists/' . $list_id);
	}
}