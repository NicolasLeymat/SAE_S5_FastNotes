@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
            <table class="eleve-tab">
                <thead class="tab-row-dark">
                  <tr>   
                    <th>Code prof</th>
                    <th>Groupe</th>
                    <th>Ressource</th>
                    <th></th>
                  </tr> 
                </thead>
                @for ($i = 0; $i < count($tabEnseignements); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabEnseignements[$i]->code_prof}}</td>
                    <td class="tab-cell" >{{ $tabEnseignements[$i]->id_groupe}}</td>
                    <td class="tab-cell" >{{ $tabEnseignements[$i]->code_ressource}}</td>  
                    <td><a class="clear-cell button del-button " href="#">Supprimer </a> </td>
                  </tr>
                @endfor
            </table>
          </div>
@endsection