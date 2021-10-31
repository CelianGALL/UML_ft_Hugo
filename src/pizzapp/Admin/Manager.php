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

	/**
	 * Add an ingredient to the stock to make it available for customers
	 * @param Ingredient $ingredient
	 */

	public function addIngredientToStock(Ingredient $ingredient)
	{
		$this->global_stock[$ingredient->name] = $ingredient;
	}

	/**
	 * Remove an ingredient from the stock
	 * @param Ingredient $ingredient
	 */
	public function removeIngredientFromStock(Ingredient $ingredient)
	{
		unset($this->global_stock[$ingredient->name]);
	}

	/**
	 * Add a recipe to the recipes list
	 * @param Recipe $recipe
	 */
	public function addRecipe(Recipe $recipe)
	{
		$this->recipes[$recipe->name] = $recipe;
	}

	/**
	 * Display the recipes
	 */
	public function showRecipes()
	{
		return Recipe::showRecipes();
	}

	/**
	 * Display all the commands made
	 */
	public function showCommands()
	{
		return Command::$commands_list;
	}

	/**
	 * Display all the prices of all ingredients
	 */
	public function showPrices()
	{
		foreach ($this->global_stock as $ingredient) {
			$ingredient_stock_value = $ingredient->quantity * $ingredient->price;
			echo "\n $ingredient->name : $ingredient->price €/unit.";
		}
	}

	/**
	 * Show ingredients quantity in stock
	 */
	public function showStockValues()
	{
		foreach ($this->global_stock as $ingredient) {
			$ingredient_stock_value = $ingredient->quantity * $ingredient->price;
			echo "\n $ingredient->name's stock value : $ingredient_stock_value €.";
		}
	}

	/**
	 * Change the price of an ingredient
	 * @param Ingredient $ingredient
	 * @param $newprice
	 */
	public function changePrice(Ingredient $ingredient, $newprice)
	{
		$ingredient->price = $newprice;
	}

	/**
	 * Change Mario's margin
	 * @param $new_margin
	 */
	public function changeMargin($new_margin)
	{
		if ($new_margin >= 1) {
			self::$margin = $new_margin;
		} else {
			echo 'Wrong margin, you\'ll be bankrupt in no time !';
		}
	}

	/**
	* Allows admin to see all ingredients + its quantity
	*/
	public function showIngredients()
	{
		foreach (Ingredient::$ingredients_list as $ingredient) {
			echo "\n$ingredient->type : $ingredient->name ($ingredient->price €, Qty : $ingredient->quantity)";
		}
	}
}
