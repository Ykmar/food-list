<?php

namespace Tests\Unit;

use Mockery;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Config\Repository;
use App\Services\Recipe\RecipeService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipeServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_summer_recipes()
    {
        $summerDate = Carbon::create(null, 7, 20);
        Carbon::setTestNow($summerDate);

        $simpleRecipe = factory(\App\Models\Recipe::class)->create([
            'season' => 'summer',
            'big' => false,
        ]);

        $bigRecipe = factory(\App\Models\Recipe::class)->create([
            'season' => 'summer',
            'big' => true,
        ]);

        $wrongRecipe = factory(\App\Models\Recipe::class)->create([
            'season' => 'winter',
            'big' => true,
        ]);

        $service = $this->makeService();

        $recipes = $service->getAvailableRecipes();

        $this->assertEquals($simpleRecipe->id, $recipes->first()->id);
        $this->assertEquals($bigRecipe->id, $recipes->last()->id);
        $this->assertNotContains($wrongRecipe, $recipes);
    }

    /** @test */
    public function can_get_winter_recipes()
    {
        $winterDate = Carbon::create(date('Y') + 1, 2, 7);
        Carbon::setTestNow($winterDate);

        $simpleRecipe = factory(\App\Models\Recipe::class)->create([
            'season' => 'winter',
            'big' => false,
        ]);

        $bigRecipe = factory(\App\Models\Recipe::class)->create([
            'season' => 'winter',
            'big' => true,
        ]);

        $wrongRecipe = factory(\App\Models\Recipe::class)->create([
            'season' => 'summer',
            'big' => true,
        ]);

        $service = $this->makeService();

        $recipes = $service->getAvailableRecipes();

        $this->assertEquals($simpleRecipe->id, $recipes->first()->id);
        $this->assertEquals($bigRecipe->id, $recipes->last()->id);
        $this->assertNotContains($wrongRecipe, $recipes);
    }

    /**
     * Make a new instance of the service
     *
     * @return \App\Services\Recipe\RecipeService
     */
    protected function makeService()
    {
        $config = Mockery::mock(Repository::class);
        $config->shouldReceive('get')
            ->with('recipes.simple.wanted')
            ->andReturn(1);

        $config->shouldReceive('get')
            ->with('recipes.big.wanted')
            ->andReturn(1);

        return new RecipeService($config);
    }
}
