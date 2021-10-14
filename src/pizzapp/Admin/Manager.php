<?php

namespace pizzapp\Admin;

use Exception;
use pizzapp\Admin\resources\Ingredient;
use pizzapp\Admin\resources\Recipe;

class Manager
{

	public $global_stock = [];
	public $recipes = [];

	public function addIngredientToStock(Ingredient $ingredient)
	{
		$this->global_stock[$ingredient->name] = $ingredient;
	}

	public function removeIngredientFromStock(Ingredient $ingredient)
	{
		unset($this->global_stock[$ingredient->name]);
	}

	public function addRecipe(Recipe $recipe)
	{
		$this->recipes[$recipe->name] = $recipe;
	}

	public function showRecipe()
	{
		foreach ($this->recipes as $key => $value) {
			echo "\nRecipe : $value->name, Price : $value->price €, Ingredients : ";
			foreach ($value->base as $b) {
				echo "$b->name / ";
			}
			foreach ($value->ingredients_list as $value) {
				echo "$value->name / ";
			}
		}
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
			echo "\n $ingredient->name : $ingredient->price €/unit.";
		}
	}

	public function showStockValues()
	{
		foreach ($this->global_stock as $ingredient) {
			$ingredient_stock_value = $ingredient->quantity * $ingredient->price;
			echo "\n $ingredient->name's stock value : $ingredient_stock_value €.";
		}
	}

	public function changePrice(Ingredient $ingredient, $newprice)
	{
		$ingredient->price = $newprice;
	}

}
