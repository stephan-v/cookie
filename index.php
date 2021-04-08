<?php

use Cookie\Cookie;
use Cookie\Ingredients\Ingredient;

require __DIR__ . '/vendor/autoload.php';

$cookie = new Cookie();

$sprinkles = new Ingredient('Sprinkles', 2, 0, -2, 0, 3);
$cookie->addIngredient($sprinkles);

$butterscotch = new Ingredient('Butterscotch', 0, 5, -3, 0, 3);
$cookie->addIngredient($butterscotch);

$chocolate = new Ingredient('Chocolate', 0, 0, 5, -1, 8);
$cookie->addIngredient($chocolate);

$candy = new Ingredient('Candy', 0, -1, 0, 5, 8);
$cookie->addIngredient($candy);

echo $cookie->getOptimalScore() . PHP_EOL;