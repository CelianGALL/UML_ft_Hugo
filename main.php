<?php

use utils\AbstractClassLoader;
use utils\ClassLoader;

require_once 'src/utils/AbstractClassLoader.php';
require_once 'src/utils/ClassLoader.php';
$loader = new \utils\ClassLoader('src');
$loader->register();

use pizzapp\Pizza as Pizza;

$pizza1 = new Pizza();
$ingredients_pizza1 = array("tomate","jambon","champignon");
$pizza1->ajouterIngredient($ingredients_pizza1);
$pizza1->ajouterIngredient("ananas");

$pizza1->afficherPizza();