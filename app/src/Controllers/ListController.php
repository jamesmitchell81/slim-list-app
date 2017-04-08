<?php

namespace App\Controllers;

use Slim\Views\PhpRenderer as View;
use Psr\Log\LoggerInterface;

use App\Persistence\Storage;
use App\Repository\ListRepository;

class ListController
{
	private $view;
	private $logger;
	private $store;

	public function __construct(View $view, LoggerInterface $logger, Storage $store)
	{
		$this->view = $view;
		$this->logger = $logger;
		$this->store = $store;
	}

	public function display($request, $response, $args)
	{
		$this->logger->info("User xx displayed lists");
		// session get user.
		$user_id = $_SESSION['user_id'];

		// temp get from Auth etc.
		$args['user_id'] = $user_id;

		// get user lists.
		$repository = new ListRepository($this->store);


		// get template.

		// return response.
		return $this->view->render($response, 'lists.phtml', $args);
	}
}