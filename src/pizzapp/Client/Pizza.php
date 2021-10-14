<?php

namespace pizzapp\Client;

use Exception;

class Pizza
{

	private $ingredients = array();
	private $base, $size;

	public function displayPizza()
	{
		if (isset($this->ingredients)) {
			echo ("List of ingredients : ");
			var_dump($this->ingredients);
		}
		if (isset($this->base)) {
			echo ("Base : $this->base.");
		}
		if (isset($this->size)) {
			echo ("Size : $this->size.");
		}
	}

	public function addIngredient($new_ingredient)
	{
		if (is_array($new_ingredient)) {
			foreach ($new_ingredient as $ingredient) {
				array_push($this->ingredients, strtolower($ingredient));
			}
		} else if (is_string($new_ingredient)) {
			array_push($this->ingredients, strtolower($new_ingredient));
		} else {
			// Normalement, cette ligne ne sera pas utile comme on choisira des ingrédients depuis une liste prédéfinie.
			throw new Exception("$new_ingredient doesn't exist in the list of ingredients.");
		}
	}
}
