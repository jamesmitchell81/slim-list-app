<?php

namespace App\Repository;

interface Repository
{
	public function find(int $id);
	public function findBy(array $data);
	public function save();
}