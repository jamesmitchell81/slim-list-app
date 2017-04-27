<?php

class Thing
{
	private $val;

	public function __construct($val)
	{
		$this->val = $val;
	}

	public function getValue()
	{
		return $this->val;
	}
}

$arr = [];

$arr[] = new Thing(5);
$arr[] = new Thing(3);
$arr[] = new Thing(7);
$arr[] = new Thing(1);

// var_dump($arr);

function builder($method) {
	return function($a, $b) use ($method) {
		if ( method_exists($a, $method) ) {
			return $a->$method() > $b->$method() ? 1 : -1;
		}
	};
}

usort($arr, builder('getValue'));

var_dump($arr);






