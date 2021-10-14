<?php

use utils\AbstractClassLoader;
use utils\ClassLoader;

require_once 'src/utils/AbstractClassLoader.php';
require_once 'src/utils/ClassLoader.php';
$loader = new \utils\ClassLoader('src');
$loader->register();

use pizzapp\Admin\Manager as Manager;
use pizzapp\Admin\resources\Ingredients as Ingredients;

$manager = new Manager();

$tomato = new Ingredients("tomato", 10, "1.50");
$mushroom = new Ingredients("mushroom", 8, "0.20");
$cheese = new Ingredients("cheese", 20, "0.50");
$chorizo = new Ingredients("chorizo", 10, "0.70");
$pineapple = new Ingredients("pineapple", 5, "1.00");
$egg = new Ingredients("egg", 20, "0.40");
$ham = new Ingredients("ham", 10, "1.10");

$manager->addIngredientInStock($tomato);
$manager->addIngredientInStock($mushroom);
$manager->addIngredientInStock($cheese);
$manager->addIngredientInStock($chorizo);
$manager->addIngredientInStock($pineapple);
$manager->addIngredientInStock($egg);
$manager->addIngredientInStock($ham);

// $stock = $manager->showStock();
// $stock = $manager->showPrices();