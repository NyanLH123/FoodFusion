<?php

declare(strict_types=1);

class RecipeIngredient extends Model
{
    protected string $table      = 'recipe_ingredients';
    protected string $primaryKey = 'ingredientId';
}
