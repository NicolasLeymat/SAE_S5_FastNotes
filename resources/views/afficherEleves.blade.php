@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
          <div class="home_content">
            <table class="eleve-tab">
                <thead class="tab-row-dark">
                  <tr>   
                    <th>Code élève</th>
                    <th>Groupe</th>
                    <th>Parcours</th>
                    <th></th>
                  </tr> 
                </thead>
                @for ($i = 0; $i < count($tabEleves); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabEleves[$i]->code}}</td>
                    <td class="tab-cell "> {{ $listeGroupes[$i]->libelle }} </td>
                    <td class="tab-cell" >{{ $listeGroupes[$i]->parcours }}</td>
                    <td><a class="clear-cell button del-button " href="#">Supprimer </a> </td>
                  </tr>
                @endfor
            </table>
          </div>
        </div>
@endsection