@extends('layouts.fn')
@section('title', 'Ajouter un professeur')
@section('content')

<div class="home_container container grid">
    <div class="home_content">
    <h2>Ajouter un professeur </h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        
        <form action="{{route('ajouter_prof')}}" method = "POST" name="form_prof" id="form_prof" class="add_form">
            <fieldset>
            @csrf
            <label for="code">Code</label>
            <input name="code" type="text" id="code" placeholder="Code d'identification"></input>

            <label for="nom">Nom</label>
            <input name="nom" type="text" id="nom" placeholder="Nom de l'enseignant"></input>

            <label for="prenom">Prénom</label>
            <input name="prenom" type="text" id="prenom" placeholder="Prénom de l'enseignant"></input>

            <label for="email">Adresse e-mail</label>
            <input name="email" type="email" id="email" placeholder="Adresse e-mail"></input>

            <label for="password">Mot de passe </label>
            <input name="password" type="password" id="password" placeholder="Mot de passe (au moins 8 caractères,1 chiffre, 1 majuscule)"></input>

            <label for="confirm_password">Confirmer le mot de passe</label>
            <input name="confirm_password" type="password" id="password_confirm" placeholder="Entrez le même mot de passe"></input>
            


            <input name="envoyer" type="submit" class="button" value="Enregistrer"></input>
            </fieldset>
        </form>

    </div>
</div>


@endsection