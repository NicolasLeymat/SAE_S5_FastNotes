@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
            <table class="eleve-tab">
                <thead class="tab-row-dark">
                  <tr>   
                    <th>Titre</th>
                    <th>Année du semestre</th>
                    <th></th>
                  </tr> 
                </thead>
                @for ($i = 0; $i < count($tabSemestres); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabSemestres[$i]->libelle}}</td>
                    <td class="tab-cell" >{{ $tabSemestres[$i]->id_annee}}</td>  
                    <td><a class="clear-cell button del-button " href="#">Supprimer </a> </td>
                  </tr>
                @endfor
            </table>
          </div>
@endsection