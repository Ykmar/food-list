<?php

namespace App\Services\Recipe;

use Carbon\Carbon;
use App\Models\Recipe;

class RecipeService
{
    /**
     * Retourne 5 recettes en fonction de la période de l'année
     *
     * @return \App\Models\Recipe[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getAvailableRecipes()
    {
        $today = Carbon::now();

        switch ($today) {
            case $today->between(Carbon::createFromFormat('dd-mm', '01-10'), Carbon::createFromFormat('dd-mm', '01-03')):
                return $this->getRecipesBySeason('winter');
            case $today->between(Carbon::createFromFormat('dd-mm', '01-06'), Carbon::createFromFormat('dd-mm', '01-09')):
                return $this->getRecipesBySeason('summer');
            default:
                return $this->getRecipes();
        }
    }

    /**
     * Retourne une liste de recettes
     *
     * @return \App\Models\Recipe[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    protected function getRecipes()
    {
        $bigOnes = $this->getBigRecipes();

        $recipes = Recipe::all()->random(3);

        $recipes->merge($bigOnes);

        return $recipes;
    }

    /**
     * Retourne une liste de recettes en fonction de la saison
     *
     * @param $season
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
     * @param string|null $season
     * @return mixed
     */
    protected function getBigRecipes($season = null)
    {
        if ($season) {
            return Recipe::where('big', true)
                ->where('season', $season)
                ->random(2);
        }

        return Recipe::where('big', true)->random(2);
    }
}
