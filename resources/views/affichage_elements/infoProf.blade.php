@extends('layouts.fn')

@section('title', 'Infos prof '.$utilisateur->nom)

@section('content')
<div class ="home_container container grid">
    <div class="home_content">
        <div>
        <h2> Informations sur {{$utilisateur->nom}} {{$utilisateur->prenom}} </h2>

        <h3> Code de connexion  : {{$utilisateur->code}}</h3>
        <h3> Adresse mél : {{$utilisateur->email}}</h3>
        </div>

        <h2> Enseignements </h2>
        <table class="note-tab">
            <tr class="tab-row tab-row-dark">
                <th>Ressource</th>
                <th>Groupe</th>
                <th>Semestre</th>
                <th>Période</th>
            </tr>

        @foreach ($resListe as $enseignement )
            <tr clas="tab-row tab-row-clear">
                <td class="tab-cell">{{$enseignement["nomRessource"]}}</td>
                <td class="tab-cell centered-cell">{{$enseignement["groupe"]}}</td>
                <td class="tab-cell">{{$enseignement["semestre"]}}</td>
                <td class="tab-cell">{{$enseignement["periode"]}}</td>
            </tr>
        @endforeach
        </table>
    </div>
</div>


@endsection