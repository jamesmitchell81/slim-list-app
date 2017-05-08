<?php

namespace App\Repository;

use App\Persistence\Database;
use App\Persistence\Statement;

use App\Entity\AppList;
// use App\Util\Filters;

class ListRepository
{
    use \App\Util\Filters;

	private $db;
	private $collection;

	public function __construct(Database $db)
	{
		$this->db = $db;
		return $this;
	}

	private function set(array $data) : AppList
    {
        $list = new AppList;
        $list->setId($data['id']);
        $list->setListName($data['list_name']);
        $list->setComplete((bool)$data['complete']);
        $list->setCreated($data['created']);
        $list->setUpdated($data['updated']);
        return $list;
    }

    public function first()
    {
        if ( count($this->collection) > 0 )
            return $this->collection[0];

        return false;
    }

    public function all()
    {
        return $this->lists;
    }

    public function length()
    {
        return count($this->collection);
    }

    public function filter($prop, $value)
    {
        return $this->entityArrayFilter($prop, $value);
    }

    public function sort(array $fields)
    {
        return new EntitySorter($this->collection, $fields);
    }

	public function find(int $id) : AppList // X
    {
        $SQL = "SELECT * FROM app_lists WHERE id = :list_id";

        $statement = new Statement($this->db);
        $query = $statement->prepare($SQL)->bind(
            ['list_id' => $id]
        )->fetch();

        if ( !$query ) return false;

        return $this->set($query);
    }

    public function findByUser(int $user_id)
    {
        $SQL = "SELECT * FROM app_lists WHERE user_id = :user_id";
        $query = (new Statement($this->db))->prepare($SQL)->bind([ 'user_id' => $user_id ])->fetchAll();

        foreach ( $query as $row )
            $this->collection[] = $this->set($row);

        return $this;
    }

    public function findBy(array $params)
    {
        $conditions = [];

        foreach ( $params as $key => $value )
            $conditions[] = "{$key} = :{$key}";

        $SQL = "SELECT * FROM app_lists WHERE " . join(" AND ", $conditions);

        $statement = new Statement($this->db);
        $statement->prepare($SQL);
        $statement->bind($params);
        $query = $statement->fetchAll();

        foreach ( $query as $row )
            $this->collection[] = $this->set($row);

        return $this;
    }

    public function add(AppList $list) : int
    {
        $SQL = "INSERT INTO app_lists (list_name, user_id) VALUES (:list_name, :user_id)";

        $statement = new Statement($this->db);
        $query = $statement->prepare($SQL)->bind(
            [
                'user_id'   => $list->getUser()->getId(),
                'list_name' => $list->getListName()
            ]
        )->execute();

        if ( !$query ) return false;

        return $statement->getLastInsertId();
    }

}