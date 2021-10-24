<?php

use utils\AbstractClassLoader;
use utils\ClassLoader;

require_once 'src/utils/AbstractClassLoader.php';
require_once 'src/utils/ClassLoader.php';
$loader = new \utils\ClassLoader('src');
$loader->register();

require_once("assets.php");

use pizzapp\Admin\resources\Recipe;
use pizzapp\Admin\resources\Command;
use pizzapp\Admin\resources\Ingredient;
use pizzapp\Admin\Manager;
use pizzapp\Client\Customer;
use pizzapp\Client\CustomRecipe;

//Config Admin
$pseudo = "Mario";
$password = "LeBOSS";

// Step 1
//User type choise : 
echo "Welcome to MarioPizza's App !\n";
echo "1 : Customer \n";
echo "2 : Administrator\n";

while (true) {
    $usertype = readline("What kind of user are you ? :");
    if ($usertype == 1 || $usertype == 2) {
        break;
    } else {
        echo "Please, enter correct user type.\n";
    }
}
//CUSTOMER PART:
if ($usertype == 1) {
    echo "\nYour choice : Client\n";
    $customer_name = readline("Enter your name : ");
    echo "\n1 : Select a pizza in the list";
    echo "\n2 : Create your own pizza\n";
    $action = readline("Your choice : ");

    $customer = new Customer($customer_name);
    $command = new Command($customer);
    $recipes = Recipe::$recipes_list;

    if ($action == "1") {
        while (true) {
            Recipe::showRecipes();
            echo "\n\n- If you want more than one, separate names with commas\n- One occurence will count as one pizza so if you want the same pizza 'x' times, type its name 'x' times separated with commas\n";
            $pizza_name = readline("Enter the name of the pizza you want : ");
            // To avoid name conflicts : 
            $pizza_name = str_replace(' ', '', $pizza_name);
            $pizza_name_array = explode(',', $pizza_name);
            $pizza_name_array = array_filter($pizza_name_array);

            // Adding recipes to command
            foreach ($pizza_name_array as $pizza_name) {
                $command->addItem($recipes[$pizza_name], null);
            }

            while (true) {
                // Command resume :
                echo ("\nYour command :");
                $command->getCommand();
                echo "\n";

                $modify_choice = readline("Do you want to modify your command ? [Yes / No] : ");
                if ($modify_choice == "Yes") {
                    while (true) {
                        echo "1 : Remove or add a pizza to your command\n";
                        echo "2 : Remove or add an ingredient to a pizza\n";
                        echo "3 : Cancel\n";
                        $modify_choice = readline("Your choice : ");
                        echo "\n";
                        if ($modify_choice == "1") {
                            while (true) {
                                $remove_or_add_choice = readline("Do you want to remove or add a pizza to your command ? [Add / Remove / Cancel] : ");
                                if ($remove_or_add_choice == "Add") {
                                    Recipe::showRecipes();
                                    echo "\n- If you want more than one, separate names with commas\n- One occurence will count as one pizza so if you want the same pizza 'x' times, type its name 'x' times separated with commas\n";
                                    $pizza_to_add = readline("Enter the name of the pizza you want to add : ");
                                    $pizza_to_add = str_replace(' ', '', $pizza_to_add);
                                    $pizza_name_array_to_add = explode(',', $pizza_to_add);

                                    foreach ($pizza_name_array_to_add as $pizza_name) {
                                        $command->addItem($recipes[$pizza_name], null);
                                    }

                                    echo ("\nYour command after modifications :");
                                    $command->getCommand();
                                    echo "\n";
                                }
                                if ($remove_or_add_choice == "Remove") {
                                    $pizza_to_remove = readline("Chose which pizza's number you want to remove (separate numbers with commas) : ");
                                    $pizza_to_remove = str_replace(' ', '', $pizza_to_remove);
                                    $pizza_number_array_to_remove = explode(',', $pizza_to_remove);

                                    foreach ($pizza_number_array_to_remove as $pizza_number) {
                                        $command->removeItem($pizza_number);
                                    }
                                }
                                if ($remove_or_add_choice == "Cancel") {
                                    break;
                                }
                            }
                        }
                        if ($modify_choice == "2") {
                            $pizza_number_to_modify = readline("Chose the pizza number you want to modify : ");
                            $remove_or_add_choice = readline("Do you want to remove or add an ingredient to your pizza ? [Add / Remove / Cancel] : ");
                            if ($remove_or_add_choice == "Add") {
                                Ingredient::showIngredients();
                                echo "\n";
                                $custom_recipe = new CustomRecipe($command->items[(intval($pizza_number_to_modify) - 1)]->name);
                                // Overwrite Recipe index with CustomRecipe
                                $command->addItem($custom_recipe, $pizza_number_to_modify);
                                $ingredients_to_add = readline("Type in ingredient name you want to add to your pizza (separate names with commas) : ");
                                $ingredients_to_add = str_replace(' ', '', $ingredients_to_add);
                                $ingredients_to_add_array = explode(',', $ingredients_to_add);
                                foreach ($ingredients_to_add_array as $ingredient) {
                                    $custom_recipe->addIngredientToRecipe($ingredient);
                                }
                            }
                            if ($remove_or_add_choice == "Remove") {
                                $custom_recipe = new CustomRecipe($command->items[(intval($pizza_number_to_modify) - 1)]->name);
                                // Overwrite Recipe index with CustomRecipe
                                $command->addItem($custom_recipe, $pizza_number_to_modify);
                                $custom_recipe->showRecipe();
                                echo "\n";
                                $ingredients_to_remove = readline("Type in ingredient name you want to remove from your pizza (separate names with commas) : ");
                                $ingredients_to_remove = str_replace(' ', '', $ingredients_to_remove);
                                $ingredients_to_remove_array = explode(',', $ingredients_to_remove);
                                foreach ($ingredients_to_remove_array as $ingredient) {
                                    $custom_recipe->removeIngredientFromRecipe($ingredient);
                                }
                            }
                            if ($remove_or_add_choice == "Cancel") {
                                break;
                            }
                        }
                        if ($modify_choice == "3") {
                            break;
                        }
                    }
                } else {
                    echo '\nCommand sent to Mario ! Bill : ' . $command->getBill();
                    break;
                }
            }
            break;
        }
    }
    if ($action == "2") {
        Ingredient::showIngredients();
        echo "\n";
        $base_list_custom_pizza = [];
        $ingredients_list_custom_pizza = [];

        $ingredients_to_add = readline("Type in ingredient name you want to add to your pizza (separate names with commas), you need at least one dough type ingredient : ");
        $ingredients_to_add = str_replace(' ', '', $ingredients_to_add);
        $ingredients_to_add_array = explode(',', $ingredients_to_add);
        foreach ($ingredients_to_add_array as $ingredient) {
            if (Ingredient::$ingredients_list[$ingredient]->type == "base") {
                $base_list_custom_pizza[$ingredient] = Ingredient::$ingredients_list[$ingredient];
            }
            if (Ingredient::$ingredients_list[$ingredient]->type == "ingredient") {
                $ingredients_list_custom_pizza[$ingredient] = Ingredient::$ingredients_list[$ingredient];
            }
        }

        // Create real Recipe
        $empty_recipe = new Recipe("Custom pizza", $base_list_custom_pizza, $ingredients_list_custom_pizza);
        // to create a CustomRecipe from it
        $custom_recipe = new CustomRecipe("Custom pizza", $base_list_custom_pizza, $ingredients_list_custom_pizza);
        $quantite_custom_pizza = readline("How many pizzas like this do you want ? : ");
        $quantite_custom_pizza = intval($quantite_custom_pizza);
        if ($quantite_custom_pizza > 0) {
            for ($i = 0; $i < $quantite_custom_pizza; $i++) {
                $command->addItem($custom_recipe, null);
            }
        }
        // then delete it
        unset(Recipe::$recipes_list[$empty_recipe->name]);


        echo "\nYour command : ";
        $command->getCommand();
        echo "\n";

        while (true) {
            $modify_choice = readline("Do you want to modify your command ? [Yes / No] : ");
            if ($modify_choice == "Yes") {
                while (true) {
                    echo "1 : Remove or add a pizza to your command\n";
                    echo "2 : Remove or add an ingredient to a pizza\n";
                    echo "3 : Cancel\n";
                    $modify_choice = readline("Your choice : ");
                    echo "\n";
                    if ($modify_choice == "1") {
                        while (true) {
                            $remove_or_add_choice = readline("Do you want to remove or add a pizza to your command ? [Add / Remove / Cancel] : ");
                            if ($remove_or_add_choice == "Add") {
                                Ingredient::showIngredients();
                                echo "\n";
                                $base_list_custom_pizza = [];
                                $ingredients_list_custom_pizza = [];

                                $ingredients_to_add = readline("Type in ingredient name you want to add to your pizza (separate names with commas), you need at least one dough type ingredient : ");
                                $ingredients_to_add = str_replace(' ', '', $ingredients_to_add);
                                $ingredients_to_add_array = explode(',', $ingredients_to_add);
                                foreach ($ingredients_to_add_array as $ingredient) {
                                    if (Ingredient::$ingredients_list[$ingredient]->type == "base") {
                                        $base_list_custom_pizza[$ingredient] = Ingredient::$ingredients_list[$ingredient];
                                    }
                                    if (Ingredient::$ingredients_list[$ingredient]->type == "ingredient")
                                        $ingredients_list_custom_pizza[$ingredient] = Ingredient::$ingredients_list[$ingredient];
                                }

                                // Create real Recipe
                                $empty_recipe = new Recipe("Custom pizza", $base_list_custom_pizza, $ingredients_list_custom_pizza);
                                // to create a CustomRecipe from it
                                $custom_recipe = new CustomRecipe("Custom pizza", $base_list_custom_pizza, $ingredients_list_custom_pizza);
                                $quantite_custom_pizza = readline("How many pizzas like this do you want ? : ");
                                $quantite_custom_pizza = intval($quantite_custom_pizza);
                                if ($quantite_custom_pizza > 1) {
                                    for ($i = 0; $i < $quantite_custom_pizza; $i++) {
                                        $command->addItem($custom_recipe, null);
                                    }
                                }
                                // then delete it
                                unset(Recipe::$recipes_list[$empty_recipe->name]);

                                echo ("\nYour command after modifications :");
                                $command->getCommand();
                                echo "\n";
                            }
                            if ($remove_or_add_choice == "Remove") {
                                $pizza_to_remove = readline("Chose which pizza's number you want to remove (separate numbers with commas) : ");
                                $pizza_to_remove = str_replace(' ', '', $pizza_to_remove);
                                $pizza_number_array_to_remove = explode(',', $pizza_to_remove);

                                foreach ($pizza_number_array_to_remove as $pizza_number) {
                                    $command->removeItem($pizza_number);
                                }
                                echo ("\nYour command after modifications :");
                                $command->getCommand();
                                echo "\n";
                            }
                            if ($remove_or_add_choice == "Cancel") {
                                break;
                            }
                        }
                    }
                    if ($modify_choice == "2") {
                        $pizza_number_to_modify = readline("Chose the pizza number you want to modify : ");
                        $remove_or_add_choice = readline("Do you want to remove or add an ingredient to your pizza ? [Add / Remove / Cancel] : ");
                        $pizza_to_modify = $command->items[(intval($pizza_number_to_modify) - 1)];
                        if ($remove_or_add_choice == "Add") {
                            Ingredient::showIngredients();
                            echo "\n";
                            $ingredients_to_add = readline("Type in ingredient name you want to add to your pizza (separate names with commas) : ");
                            $ingredients_to_add = str_replace(' ', '', $ingredients_to_add);
                            $ingredients_to_add_array = explode(',', $ingredients_to_add);

                            foreach ($ingredients_to_add_array as $ingredient) {
                                $pizza_to_modify->addIngredientToRecipe($ingredient);
                            }
                            echo ("\nYour command after modifications :");
                            $command->getCommand();
                            echo "\n";
                        }
                        if ($remove_or_add_choice == "Remove") {
                            $pizza_to_modify->showRecipe();
                            echo "\n";
                            $ingredients_to_remove = readline("Type in ingredient name you want to remove from your pizza (separate names with commas) : ");
                            $ingredients_to_remove = str_replace(' ', '', $ingredients_to_remove);
                            $ingredients_to_remove_array = explode(',', $ingredients_to_remove);
                            $pizza_to_modify = $command->items[(intval($pizza_number_to_modify) - 1)];
                            foreach ($ingredients_to_remove_array as $ingredient) {
                                $pizza_to_modify->removeIngredientFromRecipe($ingredient);
                            }
                            echo ("\nYour command after modifications :");
                            $command->getCommand();
                            echo "\n";
                        }
                        if ($remove_or_add_choice == "Cancel") {
                            break;
                        }
                    }
                    if ($modify_choice == "3") {
                        break;
                    }
                }
            } else {
                echo "\n";
                echo 'Command sent to Mario ! Bill : ' . $command->getBill();
                break;
            }
        }
    }
}


//ADMIN PART:
if ($usertype == 2) {
    echo "Your choice : Admin\n\n";
    echo "Connection : \n";


    //ADMIN connection
    $testpseudo = "";
    $testpassword = "";

    while ($testpseudo != $pseudo) {
        echo ("Wrong pseudo\n\n");
        $testpseudo = readline("User : ");
    }

    while ($testpassword != $password) {
        echo ("Wrong password\n\n");
        $testpassword = readline("Password : ");
    }

    echo "\nHello Mario !";
    $manager = new Manager();
    $manager->showStock();
    //SELECTION Choice
    echo "ADMIN Choice :";
    echo "1 : View orders";
    echo "1 : manage the pizza menu";
    echo "2 : manage the stock";
    while (true) {
        $userchoice = readline("Which choice : \n");
        if ($userchoice == 1 || $userchoice == 2 || $userchoice == 3) {
            break;
        }
    }

    if ($userchoice == 2) {
        echo "1 : list all pizzas";
        echo "2 : add new pizza";
        echo "3 : remove pizza";
        echo "4 : Change pizzas' prices";

        while (true) {
            $userchoice = readline("Which choice : \n");
            if ($userchoice == 1 || $userchoice == 2 || $userchoice == 3 || $userchoice == 4) {
                break;
            }
        }
        if ($userchoice == 1) {
        }
        if ($userchoice == 2) {
        }
        if ($userchoice == 3) {
        }
        if ($userchoice == 4) {
        }
    }

    if ($userchoice == 3) {
        echo "1 : list the stock";
        echo "2 : add new ingredients";
        echo "3 : manage the stock of an ingredient ";
        echo "4 : Change ingredient's prices";

        while (true) {
            $userchoice = readline("Which choice : \n");
            if ($userchoice == 1 || $userchoice == 2 || $userchoice == 3 || $userchoice == 4) {
                break;
            }
        }
        if ($userchoice == 1) {
            echo "test1";
        }
        if ($userchoice == 2) {
            echo "test2";
        }
        if ($userchoice == 3) {
            echo "test3";
        }
        if ($userchoice == 4) {
            echo "test4";
        }
    }
}
