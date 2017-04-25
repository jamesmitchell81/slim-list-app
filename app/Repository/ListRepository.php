<?php

namespace App\Repository;

use App\Persistence\Database;
use App\Persistence\Statement;

use App\Entity\AppList;

class ListRepository
{
	private $db;
	private $lists;

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

    public function first() : AppList
    {
        if ( count($this->lists) > 0 )
            return $this->lists[0];

        return new AppList;
    }

    public function all()
    {
        return $this->lists;
    }

    public function filter($prop, $value)
    {
        return array_filter($this->lists,
            function($v) use ($prop, $value) {
                $method = "get" . ucwords($prop);
                if ( method_exists($v, $method) )
                {
                    return $v->$method() == $value;
                }
            }
        );
    }

	public function find(int $id) : AppList
    {
        $SQL = "SELECT * FROM app_lists WHERE id = :list_id";

        $statement = new Statement($this->db);
        $query = $statement->prepare($SQL)->bind(
            ['list_id' => $id]
        )->fetch();

        if ( !$query ) return new AppList;

        return $this->set($query);
    }

    public function findByUser(int $user_id)
    {
        $SQL = "SELECT * FROM app_lists WHERE user_id = :user_id";
        $query = (new Statement($this->db))->prepare($SQL)->bind([ 'user_id' => $user_id ])->fetchAll();

        foreach ( $query as $row )
            $this->lists[] = $this->set($row);

        return $this;
    }

    public function findBy(array $params)
    {
        $conditions = [];

        foreach ( $params as $key => $value )
            $conditions[] = "{$key} = {$key}";

        $SQL = "SELECT * FROM app_lists WHERE " . join(" AND ", $conditions);

        $query = (new Statement($this->db))->prepare($SQL)->bind($params)->fetchAll();

        foreach ( $query as $row )
            $this->lists[] = $this->set($row);

        return $this;
    }

    public function add(AppList $list) : AppList
    {
        $SQL = "INSERT INTO app_lists (list_name, user_id) VALUES (:list_name, :user_id)";

        $statement = new Statement($this->db);
        $query = $statement->prepare($SQL)->bind(
            [
                'user_id'   => $list->getUser()->getId(),
                'list_name' => $list->getListName()
            ]
        )->execute();

        if ( !$query ) return new AppList; // or something.

        return $this->find($statement->getLastInsertId());
    }

}