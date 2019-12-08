<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Services\Message\MessageService;

class RecipesController extends Controller
{
    /**
     * @var \App\Services\Message\MessageService
     */
    protected $messageService;

    /**
     * RecipesController constructor.
     *
     * @param \App\Services\Message\MessageService $messageService
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

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

    /**
     * Store a newly created recipe in storage
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $recipe = new Recipe([
            'name' => $request->get('name'),
            'ingredients' => $request->get('ingredients'),
            'description' => $request->get('description'),
            'season' => $request->get('season'),
            'big' => (bool) $request->get('big'),
        ]);

        $recipe->save();

        $this->messageService->set('success', 'La recette a bien été enregistrée');
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

    /**
     * Update the specified recipe in storage
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Recipe $recipe
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Recipe $recipe)
    {
        $recipe->update([
            'name' => $request->get('name'),
            'ingredients' => $request->get('ingredients'),
            'description' => $request->get('description'),
            'season' => $request->get('season'),
            'big' => (bool) $request->get('big'),
        ]);

        $this->messageService->set('success', 'La recette a bien été modifiée');
        return redirect()->route('recipes.show', $recipe);
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

        $this->messageService->set('success', 'La recette a bien été supprimée');
        return redirect()->route('recipes.index');
    }
}
