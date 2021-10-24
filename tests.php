<?php

use utils\AbstractClassLoader;
use utils\ClassLoader;

require_once 'src/utils/AbstractClassLoader.php';
require_once 'src/utils/ClassLoader.php';
$loader = new \utils\ClassLoader('src');
$loader->register();

use pizzapp\Admin\Manager;
use pizzapp\Admin\resources\Ingredient;
use pizzapp\Admin\resources\Recipe;
use pizzapp\Admin\resources\Command;
use pizzapp\Client\Customer;
use pizzapp\Client\CustomRecipe;

// Ingredients
$S_dough = new Ingredient("small dough", 10, "3.00");
$M_dough = new Ingredient("medium dough", 10, "4.00");
$L_dough = new Ingredient("large dough", 10, "6.00");
$XL_dough = new Ingredient("xl dough", 10, "7.00");
$XXL_dough = new Ingredient("xxl dough", 10, "7.50");
$cream = new Ingredient("cream", 10, "2.00");
$tomato = new Ingredient("tomato", 10, "1.50");
$mushroom = new Ingredient("mushroom", 8, "0.20");
$cheese = new Ingredient("cheese", 20, "0.50");
$chorizo = new Ingredient("chorizo", 10, "0.70");
$pineapple = new Ingredient("pineapple", 5, "1.00");
$egg = new Ingredient("egg", 20, "0.40");
$ham = new Ingredient("ham", 10, "1.10");
$mozzarella = new Ingredient("mozzarella", 10, "0.55");
$basilic = new Ingredient("basilic", 15, "0.10");
$potatoe = new Ingredient("potatoe", 20, "0.15");
$onion = new Ingredient("onion", 5, "0.45");


// Recipes
$regina_dough_size = $S_dough;
$regina = new Recipe("regina", [$regina_dough_size, $tomato], [$ham, $cheese, $mushroom]);
$napolitaine_dough_size = $M_dough;
$napolitaine = new Recipe("napolitaine", [$napolitaine_dough_size, $tomato], [$mozzarella, $basilic, $cheese]);
$raclette_dough_size = $XXL_dough;
$raclette = new Recipe("raclette", [$raclette_dough_size, $cream], [$potatoe, $cheese, $mushroom, $onion]);
// $raclette->addIngredientToRecipe($ham);
// $raclette->removeIngredientFromRecipe($potatoe);
// $raclette->removeIngredientFromRecipe($basilic);
Recipe::showRecipes();
$selector = readline("\nChose the recipe you want to create your recipe from :\n");
$custom_recipe = new CustomRecipe($selector);
$custom_recipe->addIngredientToRecipe($potatoe);

$customer = new Customer("Jean Gilbert");
$command = new Command($customer);
$command->addItem($regina);
// $command->addItem($napolitaine);
$customer->addCommand($command);


// Manager
$manager = new Manager();
$manager->addIngredientToStock($S_dough);
$manager->addIngredientToStock($M_dough);
$manager->addIngredientToStock($L_dough);
$manager->addIngredientToStock($XL_dough);
$manager->addIngredientToStock($XXL_dough);
$manager->addIngredientToStock($cream);
$manager->addIngredientToStock($tomato);
$manager->addIngredientToStock($mushroom);
$manager->addIngredientToStock($cheese);
$manager->addIngredientToStock($chorizo);
$manager->addIngredientToStock($pineapple);
$manager->addIngredientToStock($egg);
$manager->addIngredientToStock($ham);
$manager->addIngredientToStock($mozzarella);
$manager->addIngredientToStock($basilic);
$manager->addIngredientToStock($potatoe);
$manager->addIngredientToStock($onion);

// $manager->removeIngredientFromStock($cheese);
// $manager->removeIngredientFromStock($ham);
// $manager->removeIngredientFromStock($egg);
// $manager->removeIngredientFromStock($chorizo);
// $manager->showStock();
// $manager->showStockValues();

// $manager->showPrices();
$manager->showCommands();
// print_r($manager->showCommands());

$manager->addRecipe($regina);
$manager->addRecipe($napolitaine);
$manager->addRecipe($raclette);