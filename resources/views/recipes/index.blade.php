@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Recettes
                </div>
                <div class="card-body">
                    <a href="{{ route('recipes.create') }}" class="btn btn-primary btn-block mb-2">Créer une recette</a>
                    @foreach($recipes as $recipe)
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <h5 class="card-title">
                                            {{ $recipe->name }}
                                            (<a href="{{ route('recipes.show', $recipe) }}">voir</a>)
                                            (<a href="{{ route('recipes.edit', $recipe) }}">éditer</a>)
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
