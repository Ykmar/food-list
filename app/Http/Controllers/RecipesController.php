<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipesController extends Controller
{
    /**
     * Display the recipes list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $recipes = Recipe::all();

        return view('recipes.index', ['recipes' => $recipes]);
    }

    /**
     * Show the form for creating a new recipe
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        $recipe = new Recipe([
            'name' => $request->get('name'),
            'ingredients' => $request->get('ingredients'),
            'description' => $request->get('description'),
            'winter' => (bool) $request->get('winter'),
            'big' => (bool) $request->get('big'),
        ]);

        $recipe->save();

        return redirect()->route('recipes.show', $recipe);
    }

    /**
     * Display the specified recipe
     *
     * @param \App\Models\Recipe $recipe
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Recipe $recipe)
    {
        return view('recipes.show', ['recipe' => $recipe]);
    }

    /**
     * Show the form for editing the specified recipe
     *
     * @param \App\Models\Recipe $recipe
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Recipe $recipe)
    {
        return view('recipes.edit', ['recipe' => $recipe]);
    }

    public function update(Request $request)
    {

    }

    /**
     * Remove the specified recipe from storage
     *
     * @param \App\Models\Recipe $recipe
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return redirect()->route('recipes.index');
    }
}
