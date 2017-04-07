<?php

interface Database
{
	public function connect();
	public function close();
	public function getHost();
	public function getDatabaseName();
}