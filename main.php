<?php

use utils\AbstractClassLoader;
use utils\ClassLoader;

require_once 'src/utils/AbstractClassLoader.php';
require_once 'src/utils/ClassLoader.php';
$loader = new \utils\ClassLoader('src');
$loader->register();

use pizzapp\Client\Pizza as Pizza;

// Step 1
echo "Welcome to MarioPizza's App !";
echo "\n 1 : Select a pizza in the list";
echo "\n 2 : Create custom pizza \n";
$choice = readline("Your choice : ");

if ($choice == "1") { // Select a pizza in the list

}
if ($choice == "2") { // Create custom pizza

}

$pizza1 = new Pizza();
$pizza_ingredients = array("tomato", "ham", "mushroom");
$pizza1->addIngredient($pizza_ingredients);
$pizza1->addIngredient("egg");

$pizza1->displayPizza();
