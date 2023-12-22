@extends('layouts.fn')

@section('title', 'Liste UEs ')

@section('content')


        <div class="home_container container grid">
          <div class="home_content">
         
            <table class="prof-tab note-tab">
                <tr>
                    <th>Code UE</th>
                    <th>Libelle UE</th>
                    <th>Code compétence</th>
                    <th>Libelle compétence</th>
                    <th>Libelle semestre</th>
                    <th>Periode </th>
                </tr>
                @for ($i = 0; $i < count($tabUE); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabUE[$i]->code}}</td>
                    <td class="tab-cell" >{{ $tabUE[$i]->libelle}}</td>
                    <td class="tab-cell "> {{ $listeCompetences[$i]->code }} </td>
                    <td class="tab-cell" >{{ $listeCompetences[$i]->libelle }}</td>
                    <td class="tab-cell" >{{ $listeSemestres[$i]->libelle }}</td>
                    <td class="tab-cell" >{{ $listeSemestres[$i]->id_annee }}</td>
                    <td class="tab-cell "><button class="tab-cell clear-cell del-button " onclick="window.location.href='#'">Supprimer </button> </td>
                  </tr>
                @endfor
            </table>
          </div>
        </div>
@endsection