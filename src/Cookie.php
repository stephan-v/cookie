<?php

namespace Cookie;

use Cookie\Ingredients\IngredientInterface;
use Generator;

class Cookie
{
    /**
     * The ingredients which make up the cookie.
     *
     * @var IngredientInterface[] $ingredients
     */
    private array $ingredients;

    /**
     * Add an ingredient to the dunked cookie.
     *
     * @param IngredientInterface $ingredient
     */
    public function addIngredient(IngredientInterface $ingredient)
    {
        $this->ingredients[] = $ingredient;
    }

    /**
     * Get the optimal score of the cookie.
     *
     * @return int The product of all dunked cookie properties with the exception of calories.
     */
    public function getOptimalScore(): int
    {
        $optimalScore = 0;

        foreach ($this->getDistributionCombinations(100, count($this->ingredients)) as $divisionOfTotal) {
            $score = $this->getCookieScore($divisionOfTotal);

            if ($score > $optimalScore) {
                $optimalScore = $score;
            }
        }

        return $optimalScore;
    }

    /**
     * Get the score for the current division of ingredients.
     *
     * @param int[] $divisionOfTotal The possible combinations of teaspoons per ingredient.
     * @return int The total score.
     */
    private function getCookieScore(array $divisionOfTotal): int
    {
        $scorePerProperty = [
            'capacity' => 0,
            'durability' => 0,
            'flavor' => 0,
            'texture' => 0,
        ];

        foreach ($this->ingredients as $key => $ingredient) {
            $scorePerProperty['capacity'] += $ingredient->getCapacity() * $divisionOfTotal[$key];
            $scorePerProperty['durability'] += $ingredient->getDurability() * $divisionOfTotal[$key];
            $scorePerProperty['flavor'] += $ingredient->getFlavor() * $divisionOfTotal[$key];
            $scorePerProperty['texture'] += $ingredient->getTexture() * $divisionOfTotal[$key];
        }

        // Get the values.
        $scores = array_values($scorePerProperty);

        // Set any negative values to zero.
        $unsignedScores = array_map(fn(int $score) => max(0, $score), $scores);

        return array_product($unsignedScores);
    }

    /**
     * Get all possible combinations of a total in x groups.
     *
     * @param int $total The total amount to distribute amongst the given amount of groups.
     * @param int $groups The groups which these values can be distributed amongst.
     * @return Generator A generator function which can generate the distributed array.
     */
    private function getDistributionCombinations(int $total, int $groups): Generator
    {
        // A single group has nothing to distribute so we can push the total directly into an array.
        if ($groups === 1) {
            return yield [$total];
        }

        // Iterate the total amount as: 0...$total
        for ($i=0; $i < $total; $i++) {
            // Continue with the next total recursively.
            $remainingTotal = $total - $i;

            // Continue distributing the remaining total over the leftover groups recursively.
            // For example if we had 4 groups we now go down to 3 and distribute our remaining total amongst those.
            $remainingGroups = $groups - 1;

            foreach ($this->getDistributionCombinations($remainingTotal, $remainingGroups) as $j) {
                // Merge the current iteration together with the yielded array of the next one.
                yield array_merge([$i], $j);
            }
        }
    }
}