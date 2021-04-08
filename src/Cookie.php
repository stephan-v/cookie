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
     * Calculate the total cookie score.
     *
     * @param int $capacity The total capacity score of the cookie.
     * @param int $durability The total durability score of the cookie.
     * @param int $flavor The total flavor score of the cookie.
     * @param int $texture The total texture score of the cookie.
     * @return int The final cookie score.
     */
    private function calculateCookieScore(int $capacity, int $durability, int $flavor, int $texture): int
    {
        $scores = [
            $capacity,
            $durability,
            $flavor,
            $texture,
        ];

        // Set any negative values to zero.
        $unsignedScores = array_map(fn(int $score) => max(0, $score), $scores);

        // Multiple all values.
        return array_product($unsignedScores);
    }

    /**
     * Get the cookie scores per cookie property.
     *
     * @param int[] $divisionOfTotal The possible permutations of teaspoons per ingredient.
     * @return array The score per cookie property.
     */
    private function getCookieScoresPerProperty(array $divisionOfTotal): array
    {
        $scores = [
            'capacity' => 0,
            'durability' => 0,
            'flavor' => 0,
            'texture' => 0,
            'calories' => 0,
        ];

        foreach ($this->ingredients as $key => $ingredient) {
            $scores['capacity'] += $ingredient->getCapacity() * $divisionOfTotal[$key];
            $scores['durability'] += $ingredient->getDurability() * $divisionOfTotal[$key];
            $scores['flavor'] += $ingredient->getFlavor() * $divisionOfTotal[$key];
            $scores['texture'] += $ingredient->getTexture() * $divisionOfTotal[$key];
            $scores['calories'] += $ingredient->getCalories() * $divisionOfTotal[$key];
        }

        return $scores;
    }

    /**
     * Get all possible permutations of a sum total in x groups.
     *
     * @param int $total The total amount to distribute amongst the given amount of groups.
     * @param int $groups The groups which these values can be distributed amongst.
     * @return Generator A generator function which can generate the distributed array.
     */
    private function getDistributionPermutation(int $total, int $groups): Generator
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

            foreach ($this->getDistributionPermutation($remainingTotal, $remainingGroups) as $j) {
                // Merge the current iteration together with the yielded array of the next one.
                yield array_merge([$i], $j);
            }
        }
    }

    /**
     * Get the optimal score of the cookie.
     *
     * @param int|null $calories The optional calorie requirement.
     * @return int The product of all dunked cookie properties with the exception of calories.
     */
    public function getOptimalScore(int $calories = null): int
    {
        $optimalScore = 0;

        foreach ($this->getDistributionPermutation(100, count($this->ingredients)) as $divisionOfTotal) {
            $scores = $this->getCookieScoresPerProperty($divisionOfTotal);
            $score = $this->calculateCookieScore(
                $scores['capacity'],
                $scores['durability'],
                $scores['flavor'],
                $scores['texture']
            );

            // Conditions.
            $isScoreImprovement = $score > $optimalScore;
            $matchesCalorieRequirement = $calories === $scores['calories'];

            // Requirements.
            if (($matchesCalorieRequirement && $isScoreImprovement) || ($isScoreImprovement && !$calories)) {
                $optimalScore = $score;
            }
        }

        return $optimalScore;
    }
}