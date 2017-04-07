<?php

namespace App\Controllers;

use Slim\Views\PhpRenderer as View;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManager;

class ListController
{
	private $view;
	private $logger;
	private $em;

	public function __construct(View $view, LoggerInterface $logger, EntityManager $em)
	{
		$this->view = $view;
		$this->logger = $logger;
		$this->em = $em;
	}

	public function display($request, $response, $args)
	{
		$this->logger->info("User xx displayed lists");
		// session get user.
		$user_id = $_SESSION['user_id'];

		// temp get from Auth etc.
		$args['user_id'] = $user_id;

		// get user lists.
		$repository = $this->em->getRepository('App\Entity\AppList');
		$lists = $repository->findBy(
				['user_id' => $user_id ]
			);
		// get template.
		var_dump($lists);

		// return response.
		return $this->view->render($response, 'lists.phtml', $args);
	}
}