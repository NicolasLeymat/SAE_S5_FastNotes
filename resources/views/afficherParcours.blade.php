@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
            <table class="eleve-tab">
                <thead class="tab-row-dark">
                  <tr>   
                    <th>Parcours</th>
                    <th>Semestre</th>
                    <th>Annee</th>
                    <th></th>
                  </tr> 
                </thead>
                @for ($i = 0; $i < count($tabParcours); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabParcours[$i]->id_parcour}}</td>
                    <td class="tab-cell "> {{ $listeSemestres[$i]->libelle }} </td>
                    <td class="tab-cell "> {{ $listeSemestres[$i]->id_annee }} </td> 
                    <td><a class="clear-cell button del-button " href="#">Supprimer </a> </td>
                  </tr>
                @endfor
            </table>
          </div>
@endsection