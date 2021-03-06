@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Création d'une recette</div>
                <div class="card-body">
                    <form action="{{ route('recipes.store') }}" method="post">
                        {{ method_field('post') }}
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nom</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" value="{{ old('name') }}"/>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ingredients" class="col-sm-2 col-form-label">Ingrédients</label>
                            <div class="col-sm-10">
                                <textarea class="form-control rounded-0" name="ingredients" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control rounded-0" name="description" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Saison</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" id="winter" type="radio" name="season" value="winter" checked>
                                    <label class="form-check-label" for="winter">Hiver</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="summer" type="radio" name="season" value="summer">
                                    <label class="form-check-label" for="summer">Eté</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Plat pour plusieurs jours ?</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" id="bigTrue" type="radio" name="big" value="true" checked>
                                    <label class="form-check-label" for="bigTrue">Oui</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="bigFalse" type="radio" name="big" value="false">
                                    <label class="form-check-label" for="bigFalse">Non</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10 offset-2">
                                <button class="btn btn-primary">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
