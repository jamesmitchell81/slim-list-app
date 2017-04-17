<?php

namespace App\Persistence;

interface Database
{
	public function connection();
	public function close();
}