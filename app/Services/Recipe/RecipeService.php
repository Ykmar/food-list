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
            case $today->between(Carbon::create(null, 10, 1), Carbon::create(date('Y') + 1, 3, 1)):
                return $this->getRecipesBySeason('winter');
            case $today->between(Carbon::create(null, 6, 1), Carbon::create(null, 9, 1)):
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

        $recipes = Recipe::where('big', false)->get()->random(3);

        foreach ($bigOnes as $one) {
            $recipes->push($one);
        }

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

        $recipes = Recipe::where('season', $season)
            ->where('big', false)
            ->get()
            ->random(3);

        foreach ($bigOnes as $one) {
            $recipes->push($one);
        }

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
        $recipe = Recipe::where('big', true);

        if ($season) {
           $recipe->where('season', $season);
        }

        return $recipe->get()->random(2);
    }
}
