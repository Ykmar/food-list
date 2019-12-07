@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $recipe->name }}</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Ingredients</h5>
                        <p class="card-text">{!! nl2br($recipe->ingredients) !!}</p>
                        <h5 class="card-title">Recette</h5>
                        <p class="card-text">{{ $recipe->description }}</p>
                        <h5 class="card-title">Plat d'hiver ?</h5>
                        @if($recipe->winter)
                            <p class="card-text">Oui</p>
                        @else
                            <p class="card-text">Non</p>
                        @endif
                        <h5 class="card-title">Plat pour plusieurs jours ?</h5>
                        @if($recipe->big)
                            <p class="card-text">Oui</p>
                        @else
                            <p class="card-text">Non</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <br>
        <a href="{{ route('recipes.index') }}" class="btn btn-primary">Retour</a>
    </div>
@endsection
