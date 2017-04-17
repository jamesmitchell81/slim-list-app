<?php

namespace App\Persistence;

interface Query
{
	public function select(array $columns);
}