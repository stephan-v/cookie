<?php

namespace Cookie\Ingredients;

interface IngredientInterface
{
    /**
     * Get the calories of the ingredient.
     *
     * @return int
     */
    public function getCalories(): int;

    /**
     * Get the capacity of the ingredient.
     *
     * @return int
     */
    public function getCapacity(): int;

    /**
     * Get the durability of the ingredient.
     *
     * @return int
     */
    public function getDurability(): int;

    /**
     * Get the flavor of the ingredient.
     *
     * @return int
     */
    public function getFlavor(): int;

    /**
     * Get the name of the ingredient.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the texture of the ingredient.
     *
     * @return int
     */
    public function getTexture(): int;
}