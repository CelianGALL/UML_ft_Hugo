<?php

use utils\AbstractClassLoader;
use utils\ClassLoader;

require_once 'src/utils/AbstractClassLoader.php';
require_once 'src/utils/ClassLoader.php';
$loader = new \utils\ClassLoader('src');
$loader->register();

use pizzapp\Client\Pizza as Pizza;

//Config Admin
$pseudo = "Mario";
$password = "LeBOSS";
// Step 1
//User type choise : 
echo "Welcome to MarioPizza's App !\n";
echo "You are :\n";
echo "1 : Custommer \n";
echo "2 : Administrateur\n";

while (true) {
	$usertype = readline("Which user are you : \n");
	if ($usertype == 1 || $usertype == 2) {
		break;
	}
}
//CUSTOMER PARTS:
if ($usertype == 1) {
	echo "Your choice : Client";
    echo "\n 1 : Select a pizza in the list";
    echo "\n 2 : Create custom pizza \n";

$choice = readline("Your choice : ");

if ($choice == "1") { echo "LISTE PIZZA : ";} //afficher toute les pizzas
if ($choice == "2") { 
    echo ("Ingredients'List : ");//afficher tous les ingredients
    
    $pizza  = readline("Type in the ingredients you want :\n");
    $pizza = strtolower($pizza);
    $pizza = explode(",", $pizza);
    echo ($pizza[1].'\n');
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
            if ($userchoice == 1 || $userchoice == 2 ||$userchoice == 3 || $userchoice == 4) {
                break;
            }
        }
        if ($userchoice == 1) {}
        if ($userchoice == 2) {}
        if ($userchoice == 3) {}
        if ($userchoice == 4) {}
    }

    if ($userchoice == 3) {
        echo "1 : list the stock";
        echo "2 : add new ingredients";
        echo "3 : manage the stock of an ingredient ";
        echo "4 : Change ingredient's prices";

        while (true) {
            $userchoice = readline("Which choice : \n");
            if ($userchoice == 1 || $userchoice == 2 ||$userchoice == 3 || $userchoice == 4) {
                break;
            }
        }
        if ($userchoice == 1) {echo "test1";}
        if ($userchoice == 2) {echo "test2";}
        if ($userchoice == 3) {echo "test3";}
        if ($userchoice == 4) {echo "test4";}
    }


    

}













