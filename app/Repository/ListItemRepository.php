<?php

namespace App\Repository;

use App\Persistence\Database;
use App\Persistence\Statement;

use App\Entity\ListItem;

class ListItemRepository
{

	private $db;
	private $table = "app_list_items";
	private $collection = [];

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

		$list = (new ListRepository($this->db))->find($data['list_id']);
		$item->setList($list);

		return $item;
	}

    public function filter() {}

    public function sort(array $fields)
    {
        return new EntitySorter($this->collection, $fields);
    }

	public function first()
    {
        if ( count($this->collection) > 0 )
            return $this->collection[0];

        return new ListItem;
    }

    public function all() : array
    {
        return $this->collection;
    }

    public function length() : int
    {
        return count($this->collection);
    }

	public function find(int $id)
    {
        $SQL = "SELECT * FROM app_list_items WHERE id = :item_id";
        $query = (new Statement($this->db))->prepare($SQL)->bind(['item_id' => $id])->fetch();

        if ( !$query ) return false;

        return $this->set($query);
    }

    // $list = $repo->findByList(list_id)->first();
    public function findByList(int $list_id)
    {
        $SQL = "SELECT * FROM app_list_items WHERE list_id = :list_id";

        $query = (new Statement($this->db))->prepare($SQL)->bind(['list_id' => $list_id])->fetchAll();

        if ( !$query ) return $this;

        foreach ( $query as $row )
            $this->collection[] = $this->set($row);

        return $this;
    }

    public function findBy(array $params)
    {
        $conditions = [];

        foreach ( $params as $key => $value )
            $conditions[] = "{$key} = :{$key}";

        $SQL = "SELECT * FROM {$this->table} WHERE " . join(" AND ", $conditions);

        $query = (new Statement($this->db))->prepare($SQL)->bind($params)->fetchAll();

        if ( !$query ) return $this;

        foreach( $query as $row )
            $this->collection[] = $this->set($row);

        return $this;
    }

    public function add(ListItem $item) : int
    {
        $SQL = "INSERT INTO {$this->table} (value, list_id) VALUES (:value, :list_id)";

        $statement = new Statement($this->db);
        $query = $statement->prepare($SQL)->bind(
            [
                'value' => $item->getValue(),
                'list_id' => $item->getList()->getId()
            ]
        )->execute();

        if ( !$query ) return false;

        return $statement->getLastInsertId();
    }

    public function update(ListItem $item) : int
    {
        $fields = [];
        $fields[] = "value = :value";
        $fields[] = "complete = :complete";
        $fields[] = "active = :active";
        $fields[] = "deleted = :deleted";
        $condition = "id = :item_id";

        $params = [
            'value' => $item->getValue(),
            'complete' => $item->isComplete(),
            'active' => $item->isActive(),
            'item_id' => $item->getId(),
            'deleted' => $item->isDeleted()
        ];

        $SQL = "UPDATE {$this->table} SET " . join(", ", $fields) . " WHERE " . $condition;

        var_dump($SQL);
        exit();

        $statement = new Statement($this->db);
        $query = $statement->prepare($SQL)->bind($params)->execute();

        if ( !$query ) return false;

        return $this->find($statement->getLastInsertId());
    }
}
