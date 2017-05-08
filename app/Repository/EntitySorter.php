<?php

namespace App\Repository;

class EntitySorter
{
	private $entities;
	private $fields;

	public function __construct(array $entities, array $fields)
	{
		$this->entities = $entities;
		$this->fields = $fields;
	}

	// Currently only sorting one field.
	public function asc()
	{
        $method = "get" . ucwords($this->fields[0]);
		usort($this->entities,
			function($a, $b) use ($method) {
				if ( method_exists($a, $method))
					return $a->$method() < $b->$method();
			});
		return $this->entities;
	}

	public function desc()
	{
        $method = "get" . ucwords($this->fields[0]);
		usort($this->entities,
			function($a, $b) use ($method) {
				if ( method_exists($a, $method))
					return $a->$method() > $b->$method();
			});
		return $this->entities;
	}
}