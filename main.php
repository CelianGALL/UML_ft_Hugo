<?php

use utils\AbstractClassLoader;
use utils\ClassLoader;

require_once 'src/utils/AbstractClassLoader.php';
require_once 'src/utils/ClassLoader.php';
$loader = new \utils\ClassLoader('src');
$loader->register();

require_once("assets.php");

use pizzapp\Admin\resources\Recipe;
use pizzapp\Client\CustomRecipe;
use pizzapp\Admin\resources\Ingredient;

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
//CUSTOMER PARTS:
if ($usertype == 1) {
    echo "\nYour choice : Client";
    echo "\n1 : Select a pizza in the list";
    echo "\n2 : Create your own pizza\n";


    while (true) {
        $action = readline("Your choice : ");
        $recipes = Recipe::$recipes_list;
        Recipe::showRecipes();
        echo "\n\n- If you want more than one, separate names with commas\n- One occurence will count as one pizza so if you want the same pizza 'x' times, type its name 'x' times separated with commas\n";
        $pizza_name = readline("Enter the name of the pizza you want : ");
        // To avoid name conflicts : 
        $pizza_name = str_replace(' ', '', $pizza_name);
        $pizza_name_array = explode(',', $pizza_name);
        $pizza_name_array = array_filter($pizza_name_array);

        while (true) {
            // Command resume :
            echo ("\nYour command :");
            foreach ($pizza_name_array as $key => $pizza) {
                echo "\n";
                echo '#' . (intval($key) + 1) . ' ' . $recipes[$pizza]->name . ' (' . $recipes[$pizza]->price . '€). Ingredients : ';
                foreach ($recipes[$pizza]->base as $b) {
                    echo "$b->name, ";
                }
                foreach ($recipes[$pizza]->ingredients_list as $ingredient) {
                    echo "$ingredient->name, ";
                }
            }

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
                                $pizza_to_add = readline("Enter the name of the pizza you want : ");
                                $pizza_to_add = str_replace(' ', '', $pizza_to_add);
                                $pizza_name_array_to_add = explode(',', $pizza_to_add);
                                $pizza_name_array_to_add = array_filter($pizza_name_array_to_add);
                                // Combine both pizza arrays
                                $pizza_name_array = array_merge($pizza_name_array, $pizza_name_array_to_add);
                                echo ("\nYour command after modifications :");
                                foreach ($pizza_name_array as $key => $pizza) {
                                    echo "\n";
                                    echo '#' . (intval($key) + 1) . ' ' . $recipes[$pizza]->name . ' (' . $recipes[$pizza]->price . '€). Ingredients : ';
                                    foreach ($recipes[$pizza]->base as $b) {
                                        echo "$b->name, ";
                                    }
                                    foreach ($recipes[$pizza]->ingredients_list as $ingredient) {
                                        echo "$ingredient->name, ";
                                    }
                                }
                                echo "\n";
                            }
                            if ($remove_or_add_choice == "Remove") {
                                $pizza_to_remove = readline("Chose which pizza's number you want to remove (separate numbers with commas) : ");
                                $pizza_to_remove = str_replace(' ', '', $pizza_to_remove);
                                $pizza_number_array_to_remove = explode(',', $pizza_to_remove);
                                $pizza_number_array_to_remove = array_filter($pizza_number_array_to_remove);
                                foreach ($pizza_number_array_to_remove as $pizza_number) {
                                    echo 'Pizza #' . (intval($pizza_number)) . ' removed (' . $pizza_name_array[(intval($pizza_number) - 1)] . ')';
                                    echo "\n";
                                    unset($pizza_name_array[(intval($pizza_number) - 1)]);
                                }
                                // Reindex array after unset (index are still here but empty)
                                $pizza_name_array = array_values($pizza_name_array);
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
                            $custom_recipe = new CustomRecipe($pizza_name_array[(intval($pizza_number_to_modify)-1)]);
                            $ingredients_to_add = readline("Type in ingredient name you want to add to your pizza (separate names with commas) : ");
                            $ingredients_to_add = str_replace(' ', '', $ingredients_to_add);
                            $ingredients_to_add_array = explode(',', $ingredients_to_add);
                            $ingredients_to_add_array = array_filter($ingredients_to_add_array);
                            foreach ($ingredients_to_add_array as $ingredient) {
                                $custom_recipe->addIngredientToRecipe($ingredient);
                            }
                        }
                        if ($remove_or_add_choice == "Remove") {
                            $custom_recipe = new CustomRecipe($pizza_name_array[(intval($pizza_number_to_modify)-1)]);
                            $custom_recipe->showRecipe();
                            echo "\n";
                            $ingredients_to_remove = readline("Type in ingredient name you want to remove from your pizza (separate names with commas) : ");
                            $ingredients_to_remove = str_replace(' ', '', $ingredients_to_remove);
                            $ingredients_to_remove_array = explode(',', $ingredients_to_remove);
                            $ingredients_to_remove_array = array_filter($ingredients_to_remove_array);
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
                break;
            }
        }
        break;
    }
    if ($action == "2") {
        echo ("List of ingredients : "); //afficher tous les ingredients

        $pizza  = readline("Type in the ingredients you want :\n");
        $pizza = strtolower($pizza);
        $pizza = explode(",", $pizza);
        echo ($pizza[1] . '\n');
    }
}


//ADMIN PARTS:
if ($usertype == 2) {
    echo "Your choice : Admin\n\n";
    echo "Connection : \n";


    //ADMIN connection
    $testpseudo = readline("User : ");
    while ($testpseudo != $pseudo) {
        echo ("Wrong pseudo\n\n");
        $testpseudo = readline("User : ");
    }

    while ($testpassword != $password) {
        echo ("Wrong password\n\n");
        $testpassword = readline("Password : ");
    }
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
