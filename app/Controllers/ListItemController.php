<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig as View;
use Psr\Log\LoggerInterface;

use App\Repository\ListItemRepository;
use App\Repository\ListRepository;
use App\Entity\ListItem;
use App\Persistence\Database;

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


    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function display(Request $request, Response $response, $args)
	{
		$user_id = $_SESSION['user_id'];
		$list_id = $request->getAttribute('list_id');

       // $list = (new ListRepository($this->db))->findBy(
       //     [
       //         'id' => $list_id,
       //         'user_id' => $user_id
       //     ]
       // )->first();

        // get all lists.
        $repo = new ListRepository($this->db);
        $lists = $repo->findByUser($user_id)->all();
        var_dump($list_id, $lists);
        exit();

        // order by created timestamp desc
        // $lists = $repo->sort('field')->desc();
        // $lists = $repo->sort('field')->asc();

        // $lists = $repo->sort('-field');
        // $lists = $repo->sort('+field');

        // filter the current list.
        $list = $repo->filter('id', $list_id)[0];

        $items = (new ListItemRepository($this->db))->findByList($list->getId())->all();
		$list->setItems($items);

		$args['list'] = $list;
        $args['lists'] = $lists;

		return $this->view->render($response, 'lists.html.twig', $args);
	}

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function add(Request $request, Response $response)
	{
		$list_id = $request->getAttribute('list_id');
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

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function displayEdit(Request $request, Response $response, $args)
	{
		$item_id = $request->getAttribute('item_id');
        $args['item'] = (new ListItemRepository($this->db))->find($item_id);

		return $this->view->render($response, 'list-item-edit.phtml', $args);
	}

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function edit(Request $request, Response $response)
	{
		$body = $request->getParsedBody();
		$item_id = $request->getAttribute('item_id');

		// TODO: VALIDATE!
		$item_value = $body['item_value'];

        $items = new ListItemRepository($this->db);
        $item = $items->find($item_id);
        $item->setValue($item_value);
		$item = $items->update($item);

		return $response->withRedirect('/list/' . $item->getList()->getId());
	}

	// Soft Delete.

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function delete(Request $request, Response $response)
	{
        $item_id = $request->getAttribute('item_id');

        $items = new ListItemRepository($this->db);

        $item = $items->find($item_id);
        $item->setDeleted(true);
        $item = $items->update($item);

        return $response->withRedirect('/list/' . $item->getList()->getId());
	}

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function complete(Request $request, Response $response)
	{
		$item_id = $request->getAttribute('item_id');

        $items = new ListItemRepository($this->db);

        $item = $items->find($item_id);
        $item->setComplete(
            !$item->isComplete()
        );
        $item = $items->update($item);

		return $response->withRedirect('/list/' . $item->getList()->getId());
	}

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function activate(Request $request, Response $response)
	{
		$item_id = $request->getAttribute('item_id');

        $items = new ListItemRepository($this->db);
        $item = $items->find($item_id);
        $item->setActive(true);
        $item = $items->update($item);

        return $response->withRedirect('/list/' . $item->getList()->getId());
	}

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function deactivate(Request $request, Response $response)
	{
        $item_id = $request->getAttribute('item_id');

        $items = new ListItemRepository($this->db);
        $item = $items->find($item_id);
        $item->setActive(false);
        $item = $items->update($item);

        return $response->withRedirect('/list/' . $item->getList()->getId());
	}
}