<?php

namespace App\Controllers;

use Slim\Views\PhpRenderer as View;
use Psr\Log\LoggerInterface;

class HomeController
{
	private $view;
	private $logger;

	public function __construct(View $view, LoggerInterface $logger)
	{
		$this->view = $view;
		$this->logger = $logger;
	}

	public function home($request, $response, $args)
	{
		$this->logger->info("Home Page Dispatched");
		return $this->view->render($response, 'home.phtml', $args);
	}
}