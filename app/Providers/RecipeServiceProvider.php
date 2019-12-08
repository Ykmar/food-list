<?php

namespace App\Providers;

use App\Services\Recipe\RecipeService;
use Illuminate\Support\ServiceProvider;

class RecipeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RecipeService::class, function ($app) {
            return new RecipeService();
        });
    }
}
