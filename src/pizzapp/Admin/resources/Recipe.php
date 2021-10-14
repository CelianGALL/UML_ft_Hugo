<?php

namespace pizzapp\Admin\resources;

use Exception;

class Recipe
{

	public $name;
	public $base;
	public $ingredients_list;
	public $price;

	public function __construct($name, $base, $ingredients_list, $price)
	{
		$this->name = $name;
		$this->base = $base;
		$this->ingredients_list = $ingredients_list;
		$this->price = $price;
	}
}
