<?php

namespace pizzapp\Admin\resources;

use Exception;
use pizzapp\Admin\resources\Recipe;
use pizzapp\Client\CustomRecipe;
use pizzapp\Client\Customer;
use pizzapp\Admin\Manager;

class Command
{

	public $customer;
	public $status; 				// initialized, preparing, baking, finished
	public $id;
	static public array $commands_list = [];
	public array $items = [];
	public $bill = 0;

	public function __construct(Customer $customer)
	{
		$this->customer = $customer;
		$this->status = "initialized";
		$this->id = uniqid("");
		self::$commands_list[$customer->name] = $this;
		// echo "\nYour command id : $this->id";
	}

	public function addItem($item, $index)
	{
		if (isset($item)) {
			if ($index == null) {
				array_push($this->items, $item);
			} else {
				$this->items[intval($index) - 1] = $item;
			}
		} else {
			echo 'Please, add valid item to your command.';
		}
	}

	public function removeItem($index)
	{
		if (isset($index)) {
			$index = intval($index);
			if ($this->items[$index - 1] instanceof Recipe) {
				echo 'Pizza #' . $index . ' removed (' . $this->items[$index - 1]->name . ')';
			}
			if ($this->items[$index - 1] instanceof CustomRecipe) {
				echo 'Pizza #' . $index . ' removed (' . $this->items[$index - 1]->base_recipe->name . ')';
			}

			echo "\n";
			unset($this->items[$index - 1]);
			// Reindex array after unset (index are still here but empty)
			$this->items = array_values($this->items);
		} else {
			echo 'Please, type in correct pizza number.';
		}
	}

	public function getBill()
	{
		foreach ($this->items as $item) {
			$this->bill += $item->price;
		}
		$bill_with_taxes = $this->bill * Manager::$margin;
		return $bill_with_taxes . ' ( ' . $this->bill . '€ excluding taxes)';
	}

	public function getCommand()
	{
		foreach ($this->items as $index => $item) {
			echo "\n";
			if ($item instanceof Recipe) {
				echo '#' . (intval($index) + 1) . ' ' . $item->name . ' (' . $item->price . '€). Ingredients : ';
			}
			if ($item instanceof CustomRecipe) {
				echo '#' . (intval($index) + 1) . ' ' . $item->base_recipe->name . ' (' . $item->price . '€). Ingredients : ';
			}
			foreach ($item->base as $b) {
				echo "$b->name, ";
			}
			foreach ($item->ingredients_list as $ingredient) {
				echo "$ingredient->name, ";
			}
		}
	}
}
