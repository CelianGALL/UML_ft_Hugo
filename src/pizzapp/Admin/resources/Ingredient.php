<?php

namespace pizzapp\Admin\resources;

use Exception;

class Ingredient
{

	public $name;
	public $quantity;
	public $price;

	public function __construct($name, $quantity, $price)
	{
		$this->name = $name;
		$this->quantity = $quantity;
		$this->price = $price;
	}
}
