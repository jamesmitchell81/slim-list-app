<?php

namespace App\Controllers;

use App\Repository\ListRepository;
use App\Repository\UserRepository;
use Slim\Views\PhpRenderer as View;
use Psr\Log\LoggerInterface;

use App\Persistence\Database;
use \PDO;

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

	public function display($request, $response, $args)
	{
		// TEMP: session get user.
        $user_id = $_SESSION['user_id'];

		$users = new UserRepository($this->db);
		$user = $users->find($user_id);

		$lists = (new ListRepository($this->db))->findByUser($user_id)->all();
		$user->setLists($lists);

		$args['user'] = $user;

		return $this->view->render($response, 'lists.phtml', $args);
	}

	// Add an list to a user
	public function add($request, $response, $args)
	{
		$body = $request->getParsedBody();

		$users = new UserRepository($this->db);
		$user = $users->find($_SESSION['user_id']);

		$list = new AppList();
		$list->setUser($user);
		$list->setListName($body['list_name']);

		$lists = new ListRepository($this->db);
		$list = $lists->add($list);

		return $response->withRedirect('/list/' . $list->getId());
	}
}