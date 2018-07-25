<?php

namespace App\Http\Controllers;

class Hateoas
{
	public function createData($resource)
	{
		return $resource;
	}
}