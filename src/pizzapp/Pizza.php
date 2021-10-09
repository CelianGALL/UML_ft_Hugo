<?php

namespace pizzapp;

use Exception;

class Pizza
{

	private $ingredients = array();
	private $base, $taille;

	public function afficherPizza()
	{
		if (isset($this->ingredients)) {
			echo ("Liste des ingrédients : ");
			var_dump($this->ingredients);
		}
		if (isset($this->base)) {
			echo ("Base : $this->base.");
		}
		if (isset($this->taille)) {
			echo ("Taille : $this->taille.");
		}
	}

	public function ajouterIngredient($nouvel_ingredient)
	{
		if (is_array($nouvel_ingredient)) {
			foreach ($nouvel_ingredient as $ingredient) {
				array_push($this->ingredients, strtolower($ingredient));
			}
		} else if (is_string($nouvel_ingredient)) {
			array_push($this->ingredients, strtolower($nouvel_ingredient));
		} else {
			// Normalement, cette ligne ne sera pas utile comme on choisira des ingrédients depuis une liste prédéfinie.
			throw new \Exception("L'ingrédient $nouvel_ingredient n'existe pas dans la liste des ingrédients.");
		}
	}
}
