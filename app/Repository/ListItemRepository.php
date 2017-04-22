<?php

namespace App\Repository;

use App\Persistence\Database;
use App\Persistence\Statement;

use App\Entity\ListItem;

class ListItemRepository
{

	private $db;
	private $items = [];

	public function __construct(Database $db)
	{
		$this->db = $db;
	}

	private function set(array $data) : ListItem
	{
		$item = new ListItem();
		$item->setId($data['id']);
		$item->setValue($data['value']);
		$item->setCreated($data['created']);
		$item->setUpdated($data['updated']);
		$item->setComplete((bool)$data['complete']);
		$item->setActive((bool)$data['active']);
		$item->setDeleted((bool)$data['deleted']);
		return $item;
	}

	public function first()
    {
        if ( count($this->items) > 0 )
            return $this->items[0];

        return new ListItem;
    }

    public function all()
    {
        return $this->items;
    }

	public function find(int $id) : ListItem
    {
        $SQL = "SELECT * FROM app_list_items WHERE id = :item_id";
        $query = (new Statement($this->db))->prepare($SQL)->bind(['item_id' => $id])->fetch();

        if ( !$query ) return new ListItem;

        return $this->set($query);
    }

    public function findByList(int $list_id)
    {
        $SQL = "SELECT * FROM app_list_items WHERE list_id = :list_id";

        $query = (new Statement($this->db))->prepare($SQL)->bind(['list_id' => $list_id])->fetchAll();

        if ( !$query ) $this->items[] = new ListItem;

        foreach ( $query as $row )
        {
            $this->items[] = $this->set($row);
        }

        return $this;
    }
}
