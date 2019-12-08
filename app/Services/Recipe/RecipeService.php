<?php

namespace App\Services\Recipe;

use Carbon\Carbon;
use App\Models\Recipe;

class RecipeService
{
    public function getAvailableRecipes()
    {
        $today = Carbon::now();

        switch ($today) {
            case $today->between(Carbon::createFromFormat('dd-mm', '01-10'), Carbon::createFromFormat('dd-mm', '01-03')):
                return $this->getRecipesBySeason('winter');
            case $today->between(Carbon::createFromFormat('dd-mm', '01-06'), Carbon::createFromFormat('dd-mm', '01-09')):
                return $this->getRecipesBySeason('summer');
            default:

        }
    }

    /**
     * Return recipes by season
     *
     * @param string $season
     * @return mixed
     */
    protected function getRecipesBySeason($season)
    {
        $bigOnes = $this->getBigRecipes($season);

        $recipes = Recipe::where('season', $season)->random(3);

        $recipes->merge($bigOnes);

        return $recipes;
    }

    /**
     * Retourne la liste des grosses recettes
     *
     * @param string $season
     * @return mixed
     */
    protected function getBigRecipes($season = null)
    {
        return Recipe::where('season', $season)
            ->where('big', true)
            ->random(2);
    }
}
