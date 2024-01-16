@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
            <table class="eleve-tab">
                <thead class="tab-row-dark">
                  <tr>   
                    <th>Nom</th>
                    <th>Parcours</th>
                    <th>Semestre</th>
                    <th>Période</th>
                    <th></th>
                  </tr> 
                </thead>
                @for ($i = 0; $i < count($tabGroupes); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabGroupes[$i]->libelle}}</td>
                    <td class="tab-cell" >{{ optional($tabGroupes[$i]->parcour)->id_parcour ?? '-'}}</td>
                    <td class="tab-cell" >{{ optional($tabGroupes[$i]->parcour)->semestre->libelle ?? '-'}}</td>
                    <td class="tab-cell" >{{ optional($tabGroupes[$i]->parcour)->semestre->id_annee ?? '-'}}</td>   
                    <td><a class="clear-cell button del-button " href="#">Supprimer </a> </td>
                  </tr>
                @endfor
            </table>
          </div>
@endsection