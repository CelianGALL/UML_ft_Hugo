<?php

namespace pizzapp\Admin\resources;

use Exception;
use pizzapp\Admin\resources\Recipe as Recipe;
use pizzapp\Client\Customer;
use pizzapp\Admin\Manager as Manager;

class Command
{

	public $customer;
	public $status; 				// initialized, preparing, baking, finished
	public $id;
	static public array $command_list;
	public $items;
	public $bill = 0;

	public function __construct(Customer $customer)
	{
		$this->customer = $customer;
		$this->status = "initialized";
		$this->id = uniqid("");
		self::$command_list[$this->id] = $this;
		echo "\nYour command id : $this->id";
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
			$this->bill = $this->bill * Manager::getMargin();
		}
		return $this->bill . '€';
	}

	static public function getCommand($id)
	{
		return self::$command_list[$id];
	}
}
