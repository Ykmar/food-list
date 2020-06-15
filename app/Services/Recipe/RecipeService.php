<?php

namespace App\Services\Recipe;

use Carbon\Carbon;
use App\Models\Recipe;
use Illuminate\Config\Repository;
use App\Exceptions\SeasonNotFoundException;

class RecipeService
{
    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * RecipeService constructor.
     *
     * @param \Illuminate\Config\Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Retourne 5 recettes en fonction de la période de l'année
     *
     * @return \App\Models\Recipe[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getAvailableRecipes()
    {
        $today = Carbon::now();

        switch ($today) {
            case $today->between(Carbon::create(date('Y'), 10, 1), Carbon::create(date('Y') + 1, 3, 1)):
                return $this->getRecipesBySeason('winter');
            case $today->between(Carbon::create(date('Y'), 6, 1), Carbon::create(date('Y'), 9, 1)):
                return $this->getRecipesBySeason('summer');
            default:
                throw new SeasonNotFoundException('Season not found');
        }
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

        $wanted = $this->config->get('recipes.simple.wanted');
        $recipes = Recipe::where('season', $season)
            ->where('big', false)
            ->get()
            ->random($wanted);

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
        $wanted = $this->config->get('recipes.big.wanted');

        if ($season) {
           $recipe->where('season', $season);
        }

        return $recipe->get()->random($wanted);
    }
}
