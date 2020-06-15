<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cant_see_recipes()
    {
        $this->get('recipes');

        $this->assertGuest();
    }

    /** @test */
    public function an_authenticated_user_can_see_recipes()
    {
        $user = factory(\App\Models\User::class)->create();

        $recipe = factory(\App\Models\Recipe::class)->create([
            'season' => 'winter',
            'big' => false,
        ]);

        $response = $this->actingAs($user)->get('recipes');

        $response->assertStatus(200);
        $response->assertSee('Recettes');
        $response->assertSee($recipe->name);
    }

    /** @test */
    public function an_authenticated_user_can_create_recipes()
    {
        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->get('recipes/create');
        $response->assertStatus(200);

        $infos = [
            'name' => 'Recipe test',
            'ingredients' => 'Something tasty for my test',
            'description' => 'Description',
            'season' => 'winter',
            'big' => false,
        ];

        $response = $this->actingAs($user)->post('recipes', $infos);
        $response->assertStatus(302);

        $this->assertDatabaseHas('recipes', ['name' => 'Recipe test']);
    }

    /** @test */
    public function an_authenticated_user_can_show_recipe()
    {
        $user = factory(\App\Models\User::class)->create();

        $recipe = factory(\App\Models\Recipe::class)->create([
            'season' => 'winter',
            'big' => false,
        ]);

        $response = $this->actingAs($user)->get('recipes/' . $recipe->id);
        $response->assertStatus(200);
        $response->assertSee($recipe->name);
    }

    /** @test */
    public function an_authenticated_user_can_edit_recipe()
    {
        $user = factory(\App\Models\User::class)->create();

        $recipe = factory(\App\Models\Recipe::class)->create([
            'name' => 'First name test',
            'season' => 'winter',
            'big' => false,
        ]);

        $response = $this->actingAs($user)->get('recipes/' . $recipe->id . '/edit');
        $response->assertStatus(200);
        $response->assertSee($recipe->name);

        $infos = [
            'name' => 'Second name test',
            'ingredients' => 'Something tasty for my test',
            'description' => 'Description',
            'season' => 'winter',
            'big' => false,
        ];

        $response = $this->actingAs($user)->put('recipes/' . $recipe->id, $infos);
        $response->assertStatus(302);

        $this->assertDatabaseHas('recipes', ['name' => 'Second name test']);
    }

    /** @test */
    public function an_authenticated_user_can_delete_recipe()
    {
        $user = factory(\App\Models\User::class)->create();

        $recipe = factory(\App\Models\Recipe::class)->create([
            'name' => 'Name for delete',
            'season' => 'winter',
            'big' => false,
        ]);

        $this->actingAs($user)->delete('recipes/' . $recipe->id);
        $this->assertDatabaseMissing('recipes', ['name' => 'Name for delete']);
    }
}
