<?php

namespace pizzapp\admin;

use Exception;

class StockManager
{

	protected $ingredients_stock = array();

	// Liste des ingrédients prédéfinis :

	public function addIngredientInStock($new_ingredient)
	{
		$predefined_ingredients = array(
			["tomato" => ["quantite" => 0]],
			// ["mushroom", 0],
			// ["pineapple", 0],
			// ["chorizo", 0],
			// ["egg", 0],
			// ["ham", 0],
			// ["cheese", 0]
		);
		echo $predefined_ingredients["tomate"]["quantite"];
		if (is_array($new_ingredient)) {
			foreach ($new_ingredient as $ingredient) {
				array_push($this->ingredients_stock, strtolower($ingredient));
			}
		} else if (is_string($new_ingredient)) {
			array_push($this->ingredients_stock, strtolower($new_ingredient));
		} else {
			// Normalement, cette ligne ne sera pas utile comme on choisira des ingrédients depuis une liste prédéfinie.
			throw new Exception("$new_ingredient doesn't exist in the ingredients list.");
		}
	}
}
