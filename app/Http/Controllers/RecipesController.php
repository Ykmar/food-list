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

        return view('recipes.index', compact('recipes'));
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

    }

    /**
     * Display the specified recipe
     *
     * @param \App\Models\Recipe $recipe
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact($recipe));
    }

    /**
     * Show the form for editing the specified recipe
     *
     * @param \App\Models\Recipe $recipe
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Recipe $recipe)
    {
        return view('recipes.edit', compact($recipe));
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
