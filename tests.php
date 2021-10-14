<?php

use utils\AbstractClassLoader;
use utils\ClassLoader;

require_once 'src/utils/AbstractClassLoader.php';
require_once 'src/utils/ClassLoader.php';
$loader = new \utils\ClassLoader('src');
$loader->register();

use pizzapp\Admin\Manager as Manager;
use pizzapp\Admin\resources\Ingredient as Ingredient;

$manager = new Manager();

$tomato = new Ingredient("tomato", 10, "1.50");
$mushroom = new Ingredient("mushroom", 8, "0.20");
$cheese = new Ingredient("cheese", 20, "0.50");
$chorizo = new Ingredient("chorizo", 10, "0.70");
$pineapple = new Ingredient("pineapple", 5, "1.00");
$egg = new Ingredient("egg", 20, "0.40");
$ham = new Ingredient("ham", 10, "1.10");

$manager->addIngredientToStock($tomato);
$manager->addIngredientToStock($mushroom);
$manager->addIngredientToStock($cheese);
$manager->addIngredientToStock($chorizo);
$manager->addIngredientToStock($pineapple);
$manager->addIngredientToStock($egg);
$manager->addIngredientToStock($ham);

// $stock = $manager->showStock();
// $stock = $manager->showPrices();

// $manager->removeIngredientFromStock($cheese);
// $manager->removeIngredientFromStock($ham);
// $manager->removeIngredientFromStock($egg);
// $manager->removeIngredientFromStock($chorizo);