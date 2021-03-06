<?php

use Cookie\Cookie;
use Cookie\Ingredients\Ingredient;
use PHPUnit\Framework\TestCase;

final class CookieTest extends TestCase
{
    /**
     * Test that the optimal cookie score is calculated correctly with a known correct output value.
     */
    public function testCookieScoreIsCalculatedCorrectly()
    {
        $cookie = new Cookie();

        $butterscotch = new Ingredient('Butterscotch', -1, -2, 6, 3, 8);
        $cookie->addIngredient($butterscotch);

        $cinnamon = new Ingredient('Cinnamon', 2, 3, -2, -1, 3);
        $cookie->addIngredient($cinnamon);

        $this->assertSame(62842880, $cookie->getOptimalScore());
    }

    /**
     * Test that the optimal cookie score is calculated correctly with a known correct output value.
     */
    public function testCookieScoreWithCaloricRequirementIsCalculatedCorrectly()
    {
        $cookie = new Cookie();

        $butterscotch = new Ingredient('Butterscotch', -1, -2, 6, 3, 8);
        $cookie->addIngredient($butterscotch);

        $cinnamon = new Ingredient('Cinnamon', 2, 3, -2, -1, 3);
        $cookie->addIngredient($cinnamon);

        $calories = 500;

        $this->assertSame(57600000, $cookie->getOptimalScore($calories));
    }
}