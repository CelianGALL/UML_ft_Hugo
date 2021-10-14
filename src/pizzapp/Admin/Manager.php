<?php

namespace pizzapp\Admin;

use Exception;
use pizzapp\Admin\resources\Ingredients;

class Manager
{

	public $global_stock = [];

	public function addIngredientInStock(Ingredients $ingredient)
	{
		array_push($this->global_stock, $ingredient);
	}

	public function showStock()
	{
		foreach ($this->global_stock as $ingredient) {
			echo "\n $ingredient->quantity unit(s) of $ingredient->name left ($ingredient->price €/unit).";
		}
	}

	public function showPrices()
	{
		foreach ($this->global_stock as $ingredient) {
			$ingredient_stock_value = $ingredient->quantity * $ingredient->price;
			echo "\n $ingredient->name : $ingredient->price €/unit. Stock value : $ingredient_stock_value €.";
		}
	}
}
