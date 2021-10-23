<?php

namespace pizzapp\Client;
// L'idée est de faire une classe qui extend Recipe.php sera une copie d'une des recettes afin de ne pas modifier la Recipe pour tout le monde lorsqu'un client change la recette.
// Créer une méthode dans Recipe.php qui s'appelle copyRecipe($selector) si la recipe existe dans le tableau des recipes alors il lui retourne $this (une Recipe) et donc CustomRecipe devient une recipe modifiable et envoyable à Command.php
// Dans Command.php créer une méthode addRecipe(Recipe $item) et une méthode addCustomRecipe(CustomRecipe $item)

use Exception;
use pizzapp\Admin\resources\Recipe;
use pizzapp\Admin\resources\Ingredient;

class CustomRecipe
{

	public $base_recipe;
	public array $base;
	public array $ingredients_list;
	public $price;

	public function __construct($selector)
	{
		$recipes = Recipe::$recipes_list;
		if (array_key_exists($selector, $recipes)) {
			$this->base_recipe = $recipes[$selector];
			$this->price = $this->base_recipe->price;
			$this->base = $this->base_recipe->base;
			$this->ingredients_list = $this->base_recipe->ingredients_list;
			// echo "Creation of your custom pizza recipe...";
			// $this->showRecipe();
		} else {
			echo "This recipe is not in the recipes list.";
		}
	}

	public function showRecipe()
	{

		echo "\nCurrent ingredients of your pizza : ";
		foreach ($this->base_recipe->base as $b) {
			echo "\n";
			echo $b->name . ' (' . $b->price . '€)';
		}
		foreach ($this->base_recipe->ingredients_list as $ingredient) {
			echo "\n";
			echo $ingredient->name . ' (' . $ingredient->price . '€)';
		}
		echo "\n";
	}

	// Ces méthodes ne doivent être accessibles que depuis le manager.
	// C'est un gestionnaire de recettes, pas un créateur de CustomRecipe.

	public function removeIngredientFromRecipe($ingredient_to_remove)
	{
		if (array_key_exists($ingredient_to_remove, $this->ingredients_list)) {
			unset($this->ingredients_list[$ingredient_to_remove]);
			// Reindex array after unset (index are still here but empty)
			$this->ingredients_list = array_values($this->ingredients_list);
			$this->price = $this->price - Ingredient::$ingredients_list[$ingredient_to_remove]->price;

			echo "$ingredient_to_remove removed. This pizza now costs $this->price €\n";
		} else {
			echo "Please, enter an ingredient that's in the pizza.\n";
		}
	}

	public function addIngredientToRecipe($ingredient_to_add)
	{
		if (array_key_exists($ingredient_to_add, Ingredient::$ingredients_list)) {
			$this->ingredients_list[$ingredient_to_add] = Ingredient::$ingredients_list[$ingredient_to_add];
			$this->price = $this->price + Ingredient::$ingredients_list[$ingredient_to_add]->price;

			echo "$ingredient_to_add added. This pizza now costs $this->price €\n";
		} else {
			echo "Please, enter an existing ingredient name.\n";
		}
	}
}

// Le problème : je n'ai que des noms à associer aux recettes,
// ce qui fait qu'au moment d'afficher les ingrédients,
// cela affiche les ingrédients de la recette non custom.
// Il faut réussir à les différencier au moment de lister
