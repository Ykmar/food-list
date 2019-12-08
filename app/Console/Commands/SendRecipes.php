<?php

namespace App\Console\Commands;

use App\Mail\RecipeMail;
use Illuminate\Console\Command;
use App\Services\Recipe\RecipeService;
use Illuminate\Support\Facades\Mail;

class SendRecipes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:recipes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoi une liste de cinq recettes en fonction du moment de l\'année';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param \App\Services\Recipe\RecipeService $recipeService
     * @return mixed
     */
    public function handle(RecipeService $recipeService)
    {
        $recipes = $recipeService->getAvailableRecipes();

        $message = new RecipeMail();
        $message->from(config('mail.from'));
        $message->subject('Liste de repas de la semaine');
        $message->with(['recipes' => $recipes]);

        Mail::to(config('mail.recipients'));
    }
}
