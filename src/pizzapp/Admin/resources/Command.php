<?php

namespace pizzapp\Admin\resources;

use Exception;
use pizzapp\Admin\resources\Recipe as Recipe;
use pizzapp\Client\Customer;

class Command
{

	public $customer;
	public $status; 				// initialized, preparing, baking, finished
	public $command_id;
	public $items;
	public $bill = 0;

	public function __construct(Customer $customer)
	{
		$this->customer = $customer;
		$this->status = "initialized";
		$this->command_id = uniqid("");
	}

	public function addItem(Recipe $item)
	{
		if (isset($item)) {
			$this->items[$item->name] = $item;
		} else {
			echo 'Please, add valid item to your command.';
		}
	}

	public function getBill()
	{
		if (isset($this->items)) {
			foreach ($this->items as $item) {
				$this->bill += $item->price;
			}
		}
		return $this->bill . '€';
	}
}
