<?php

namespace pizzapp\Client;

use Exception;
use pizzapp\Admin\resources\Command as Command;

class Customer
{

	public $name;
	public array $commands;

	public function __construct($name)
	{
		$this->name = $name;
	}

	public function addCommand(Command $command) {
		$this->commands[$command->id] = $command;
		$bill = $command->getBill();
		echo "\nYour command $command->id at the price of $bill has been transfered to Mario ! Status : $command->status";
	}
}
