@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
            <table class="eleve-tab">
                <thead class="tab-row-dark">
                  <tr>   
                    <th>Nom</th>
                    <th>Code</th>
                    <th></th>
                  </tr> 
                </thead>
                @for ($i = 0; $i < count($tabRessources); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabRessources[$i]->nom}}</td>
                    <td class="tab-cell" >{{ $tabRessources[$i]->code}}</td>   
                    <td><a class="clear-cell button del-button " href="#">Supprimer </a> </td>
                  </tr>
                @endfor
            </table>
          </div>
@endsection