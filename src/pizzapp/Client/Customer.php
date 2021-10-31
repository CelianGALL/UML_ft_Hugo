<?php

namespace pizzapp\Client;

use Exception;
use pizzapp\Admin\resources\Command as Command;

class Customer
{

	public $name;
	public array $commands;

	/**
	 * Constructor
	 * @param string $name
	 */
	public function __construct($name)
	{
		$this->name = $name;
	}

	/**
	 * Validate a command, shows final bill to customer
	 * @param Command $command
	 */
	public function addCommand(Command $command) {
		$this->commands[$command->id] = $command;
		$bill = $command->getBill();
		echo "\nYour command $command->id at the price of $bill has been transfered to Mario ! Status : $command->status";
	}
}
