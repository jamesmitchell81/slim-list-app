<?php

namespace App\Util;

trait Filters
{

	public function entityArrayFilter($prop, $value)
	{
        $method = "get" . ucwords($prop);
        $filter = function($v) use ($value, $method) {
                        if ( method_exists($v, $method) )
                            return $v->$method() == $value;
                    };
        $filtered = array_filter($this->collection, $filter);
        return array_values($filtered);
	}

}