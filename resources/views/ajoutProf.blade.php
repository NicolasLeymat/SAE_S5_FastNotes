@extends('layouts.fn')
@section('title', 'Ajouter un professeur')
@section('content')

<div class="home_container container grid">
    <div class="home_content">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        
        <form action="{{route('ajouter_prof')}}" method = "POST" name="form_prof" id="form_prof">
            @csrf
            Code<input name="code" type="text" id="code"></input>
            Mot de passe<input name="password" type="password" id="password"></input>
            Confirmer mot de passe<input name="confirm_password" type="password" id="password_confirm"></input>
            Adresse mel<input name="email" type="email" id="email"></input>
            Nom<input name="nom" type="text" id="nom"></input>
            Prénom<input name="prenom" type="text" id="nom"></input>
            <input name="envoyer" type="submit"></input>
        </form>

    </div>
</div>


@endsection