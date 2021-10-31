<?php

namespace pizzapp\Admin\resources;

use Exception;

class Ingredient
{

	public $name;
	public $quantity;
	public $price;
	public $type;
	static public array $ingredients_list = [];

	/**
	 * Constructor
	 * @param  string $name
	 * @param $quantity
	 * @param $price
	 * @param $type
	 */
	public function __construct($name, $quantity, $price, $type)
	{
		if (!in_array($name, self::$ingredients_list)) {
			$this->name = $name;
			$this->quantity = $quantity;
			$this->price = $price;
			$this->type = $type;
			self::$ingredients_list[$this->name] = $this;
		} else {
			echo "\nAn ingredient with this name already exists";
		}
	}

	/**
	 * show all informations about the ingredient
	 */
	static public function showIngredients() {
		foreach (self::$ingredients_list as $ingredient) {
			echo "\n$ingredient->type : $ingredient->name ($ingredient->price €)";
		}
	}
}
