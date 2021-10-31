<?php

namespace pizzapp\Admin\resources;

use Exception;
use pizzapp\Admin\resources\Ingredient as Ingredient;

class Recipe
{

	public $name;
	public array $base = [];
	public array $ingredients_list = [];
	static public array $recipes_list = [];
	public $price;

	/**
	 * Constructor
	 * @param  string $name
	 * @param  array $base
	 * @param array $ingredient_list
	 */
	public function __construct($name, $base, $ingredients_list)
	{
		if (!in_array($name, self::$recipes_list)) {
			$this->name = $name;
			foreach ($ingredients_list as $ingredient) {
				$this->price += $ingredient->price;
				$this->ingredients_list[$ingredient->name] = $ingredient;
			}
			foreach ($base as $b) {
				$this->price += $b->price;
				$this->base[$b->name] = $b;
			}
			self::$recipes_list[$this->name] = $this;
		} else {
			echo "\nA recipe with this name already exists !";
		}
	}

	/**
	 * displays all recipes
	 */
	static public function showRecipes() {
		foreach (self::$recipes_list as $recipe => $value) {
			echo "\n";
			echo 'Name : '.$value->name.' / Price : '.$value->price.'€ / Ingredients : ';
			foreach ($value->base as $b) {
				echo "$b->name (base), ";
			}
			foreach ($value->ingredients_list as $ingredient) {
				echo "$ingredient->name, ";
			}
		}
	}

	/**
	 * remove a recipe globally, only used in the admin side of the app
	 * @param $name
	 */
	static public function removeRecipe($name) {
		unset(self::$recipes_list[$name]);
		self::$recipes_list = array_values(self::$recipes_list);
	}

	/**
	 * remove an ingredient globally, only used in the admin side of the app
	 * @param Ingredient $ingredient_to_remove
	 */
	public function removeIngredientFromRecipe(Ingredient $ingredient_to_remove)
	{
		if (in_array($ingredient_to_remove, $this->ingredients_list)) {
			unset($this->ingredients_list[$ingredient_to_remove->name]);
		} else {
			echo "This ingredient is not in the recipe.";
		}
	}

	/**
	 * add an ingredient globally, only used in the admin side of the app
	 * @param Ingredient $ingredient_to_add
	 */
	public function addIngredientToRecipe(Ingredient $ingredient_to_add)
	{
		$this->ingredients_list[$ingredient_to_add->name] = $ingredient_to_add;
	}
}
