<?php

namespace Cookie\Ingredients;

class Ingredient implements IngredientInterface
{
    /**
     * The calories that this ingredient contains.
     *
     * @var int $calories
     */
    private int $calories;

    /**
     * How well this ingredient absorbs milk.
     *
     * @var int $capacity
     */
    private int $capacity;

    /**
     * How stable this ingredient is when having absorbed milk.
     *
     * @var int $durability
     */
    private int $durability;

    /**
     * How tasty this ingredient is.
     *
     * @var int $flavor
     */
    private int $flavor;

    /**
     * The name of this ingredient.
     *
     * @var string $name
     */
    private string $name;

    /**
     * The texture of this ingredient.
     *
     * @var int $texture
     */
    private int $texture;

    /**
     * Initialize a new ingredient.
     *
     * @param string $name The name of the ingredient.
     * @param int $capacity The capacity of the ingredient.
     * @param int $durability The durability of the ingredient.
     * @param int $flavor The flavor of the ingredient.
     * @param int $texture The texture of the ingredient.
     * @param int $calories The calories of the ingredient.
     */
    public function __construct(string $name, int $capacity, int $durability, int $flavor, int $texture, int $calories)
    {
        $this->name = $name;
        $this->capacity = $capacity;
        $this->durability = $durability;
        $this->flavor = $flavor;
        $this->texture = $texture;
        $this->calories = $calories;
    }

    /**
     * @inheritDoc
     */
    public function getCalories(): int
    {
        return $this->calories;
    }

    /**
     * @inheritDoc
     */
    public function getCapacity(): int
    {
        return $this->capacity;
    }

    /**
     * @inheritDoc
     */
    public function getDurability(): int
    {
        return $this->durability;
    }

    /**
     * @inheritDoc
     */
    public function getFlavor(): int
    {
        return $this->flavor;
    }

    /**
     * @inheritDoc
     */
    public function getTexture(): int
    {
        return $this->texture;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }
}