<?php

namespace pizzapp\Admin\resources;

use Exception;
use pizzapp\Admin\resources\Ingredient as Ingredient;

class Recipe
{

	public $name;
	public array $base;
	public array $ingredients_list;
	public $price;

	public function __construct($name, $base, $ingredients_list)
	{
		$this->name = $name;
		foreach ($ingredients_list as $ingredient) {
			$this->price += $ingredient->price;
			$this->ingredients_list[$ingredient->name] = $ingredient;
		}
		foreach ($base as $b) {
			$this->price += $b->price;
			$this->base[$b->name] = $b;
		}
	}

	public function removeIngredientFromRecipe(Ingredient $ingredient_to_remove)
	{
		if (in_array($ingredient_to_remove, $this->ingredients_list)) {
			unset($this->ingredients_list[$ingredient_to_remove->name]);
		} else {
			echo "This ingredient is not in the recipe.";
		}
	}

	public function addIngredientToRecipe(Ingredient $ingredient_to_add)
	{
		$this->ingredients_list[$ingredient_to_add->name] = $ingredient_to_add;
	}
}
