<?php

namespace App\Repository;

use App\Persistence\Storage;
use App\Entity\AppList;

class ListRepository implements Repository
{
	private $store;
	private $list;

	public function __construct(Storage $storage)
	{
		$this->store = $storage;
	}

	public function find(int $id) // : AppList
	{
		$this->list = new AppList;
		return $this->list;
	}

	public function findBy(array $data) // : AppList
	{
		$this->list = new AppList;

		return $this->list;
	}

	public function save()
	{
		//
		$this->store->persist([]);
	}
}