<?php

namespace App\Persistence;

interface Storage
{
	public function persist(array $data);
	public function retrive(int $id);
	public function retriveWhere(array $data)
	public function delete(int $id);
}