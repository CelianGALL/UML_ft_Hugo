<?php

namespace pizzapp\Admin;

use Exception;
use pizzapp\Admin\resources\Ingredient;
use pizzapp\Admin\resources\Recipe;
use pizzapp\Admin\resources\Command;

class Manager
{

	public $global_stock = [];
	public $recipes = [];
	static public $margin = 1.2;

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

	public function showRecipes()
	{
		return Recipe::showRecipes();
	}

	public function showStock()
	{
		foreach ($this->global_stock as $ingredient) {
			echo "\n $ingredient->quantity unit(s) of $ingredient->name left ($ingredient->price €/unit).";
		}
	}

	public function showCommands()
	{
		// Il faut créer le manager avant la commande, sinon la propriété ne sera pas accessible
		return Command::$commands_list;
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

	static public function getMargin()
	{
		return self::$margin;
	}

	static public function changeMargin($new_margin)
	{
		if ($new_margin >= 1) {
			self::$margin = $new_margin;
		} else {
			echo 'Wrong margin, you\'ll be bankrupt in no time !';
		}
	}

}
