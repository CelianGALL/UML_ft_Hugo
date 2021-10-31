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

// Gérer qu'une pizza commandée fait retirer 1 unité d'ingrédient au stock
echo "Welcome to MarioPizza's App !\n";

while (true) {

    // Step 1
    //User type choice : 
    echo "1 : Customer \n";
    echo "2 : Administrator\n";
    echo "3 : Exit\n";
    
    while (true) {
        $usertype = readline("What kind of user are you ? :");
        if ($usertype == 1 || $usertype == 2 || $usertype == 3) {
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
    
        $config = parse_ini_file("src/pizzapp/Aùdmin/config.ini");
    
        $testpseudo = readline("User : ");
        while ($testpseudo != $config["pseudo"]) {
            echo ("Wrong pseudo\n\n");
            $testpseudo = readline("User : ");
        }
    
        $testpassword = readline("Password : ");
        while ($testpassword != $config["password"]) {
            echo ("Wrong password\n\n");
            $testpassword = readline("Password : ");
        }
    
        echo "\nHello Mario !";
        $manager = new Manager();
        $manager->showIngredients();
        while (true) {
            //SELECTION Choice
            echo "ADMIN Choice :";
            echo "\n1 : View orders";
            echo "\n2 : Manage recipes";
            echo "\n3 : Manage stock";
            echo "\n4 : Exit\n";
            $userchoice = readline("Which choice : ");
    
            if ($userchoice == "1") {
                $commands = $manager->showCommands();
                foreach ($commands as $command) {
                    print_r($command);
                }
            }
    
            if ($userchoice == "2") {
                while (true) {
                    echo "\n1 : List all recipes";
                    echo "\n2 : Add new recipe";
                    echo "\n3 : Remove recipe";
                    echo "\n4 : Change margin";
                    echo "\n5 : Cancel";
                    echo ("\n");
                    $userchoice = readline("Your choice : ");
    
                    if ($userchoice == "1") {
                        Recipe::showRecipes();
                    }
    
                    if ($userchoice == "2") {

                        /* /!\ les recettes ajoutées à partir de l'interface manager n'ont pas d'index
                        * dans le tableau static de Recipe::$recipes_list ce qui amène beaucoup de bugs
                        * en chaîne côté client. Le reste fonctionne bien 
                        * (hormis retirer un ingrédient du stock)
                        */

                        echo ("\n");
                        $recipe_name = readline("Recipe name you want to add : ");
                        $manager->showIngredients();
                        echo ("\n");
                        $ingredients = readline("Type in ingredient names (separate with commas) : ");
                        $ingredients = str_replace(' ', '', $ingredients);
                        $ingredients_array = explode(',', $ingredients);
                        $ingredients_array = array_filter($ingredients_array);
    
                        foreach ($ingredients_array as $ingredient) {
                            if (Ingredient::$ingredients_list[$ingredient]->type == "base") {
                                $base_list_pizza[$ingredient] = Ingredient::$ingredients_list[$ingredient];
                            }
                            if (Ingredient::$ingredients_list[$ingredient]->type == "ingredient") {
                                $ingredients_list_pizza[$ingredient] = Ingredient::$ingredients_list[$ingredient];
                            }
                        }
    
                        $recipe = new Recipe($recipe_name, $base_list_pizza, $ingredients_list_pizza);
                        echo "\nYour recipe $recipe_name has been created !";
                        Recipe::showRecipes();
                    }
                    if ($userchoice == "3") {
                        Recipe::showRecipes();
                        echo ("\n");
                        $recipe_name = readline("Recipe name you want to remove : ");
                        Recipe::removeRecipe($recipe_name);
                        Recipe::showRecipes();
                        echo "\nYour recipe has been removed successfully";
                    }
                    if ($userchoice == "4") {
                        echo "Current margin : ";
                        echo Manager::$margin;
                        echo "\n";
                        $new_margin = readline("Type in your new margin : ");
                        $manager->changeMargin($new_margin);
                        echo "\nNew margin : ";
                        echo Manager::$margin;
                    }
                    if ($userchoice == "5") {
                        break;
                    }
                }
            }
    
            if ($userchoice == "3") {
                while (true) {
                    echo "\n1 : List stock";
                    echo "\n2 : Add new ingredients";
                    echo "\n3 : Remove ingredients";
                    echo "\n4 : Manage the stock of an ingredient ";
                    echo "\n5 : Change ingredient's prices";
                    echo "\n6 : Exit\n";
    
                    $userchoice = readline("Which choice : ");
                    if ($userchoice == "1") {
                        $manager->showIngredients();
                    }
                    if ($userchoice == "2") {
                        echo "\n";
                        $ingredient_name = readline("Ingredient name you want to add : ");
                        echo "\n";
                        $ingredient_quantity = readline("How many do you want to add ? : ");
                        echo "\n";
                        $ingredient_price = readline("How much does it cost per unit ? (example : 0.99) : ");
                        echo "\n";
                        $ingredient_type = readline("What type is it ? [base / ingredient] : ");
                        $new_ingredient = new Ingredient($ingredient_name, intval($ingredient_quantity), $ingredient_price, $ingredient_type);
                        $manager->addIngredientToStock($new_ingredient);
                        $manager->showIngredients();
                        echo "\nYour ingredient has been added successfully";
                    }
                    if ($userchoice == "3") {   
                        
                        /* 
                        * Ne fonctionne pas
                        * Regarder du côté de showIngredients, quelles choses 
                        * il display (tableau $manager::$global_stock ou Ingredient::$ingredients_list)
                        * A partir de là troubleshoot, regarder aussi l'inscription de l'ingrédient qui a l'air de
                        *  se faire dans les recipes (pour tester, ajouter un ingrédient créé depuis manager
                        * dans une pizza personnalisée, ça retourne que l'ingredient n'est pas un valide recipe???)
                        */
                        $manager->showIngredients();
                        echo "\n";
                        $ingredient_name = readline("Ingredient name you want to remove : ");
                        echo "\n";
                        $manager->removeIngredientFromStock(Ingredient::$ingredients_list[$ingredient_name]);
                        unset(Ingredient::$ingredients_list[$ingredient_name]);
                        $manager->showIngredients();
                        echo "\nYour ingredient has been removed successfully";
                    }
                    if ($userchoice == "4") {
                        $manager->showIngredients();
                        echo "\n";
                        $ingredient_name = readline("Ingredient name you want to modify quantity : ");
                        echo "\n";
                        $ingredient_quantity = readline("Enter its new quantity : ");
                        Ingredient::$ingredients_list[$ingredient_name]->quantity = $ingredient_quantity;
                        $manager->showIngredients();
                    }
                    if ($userchoice == "5") {
                        $manager->showIngredients();
                        echo "\n";
                        $ingredient_name = readline("Ingredient name you want to modify quantity : ");
                        echo "\n";
                        $ingredient_price = readline("Enter its new price : ");
                        Ingredient::$ingredients_list[$ingredient_name]->price = $ingredient_price;
                    }
                    if ($userchoice == "6") {
                        break;
                    }
                }
            }
            if ($userchoice == "4") {
                break;
            }
        }
    }

    if ($usertype == "3") {
        break;
    }
}
