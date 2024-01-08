@extends('layouts.fn')

@section('title', 'Liste UEs ')

@section('content')


        <div class="home_container container grid">
          <div class="home_content">
            <table class="UE_tab">
              <thead class="tab-row-dark">
                  <tr>
                      <th>Code UE</th>
                      <th>Libelle UE</th>
                      <th>Code compétence</th>
                      <th>Libelle compétence</th>
                      <th>Libelle semestre</th>
                      <th>Periode </th>
                      <th class="tab-cell"></th>
                  </tr>
                </thead>
                <tbody>
                @for ($i = 0; $i < count($tabUE); $i++)
                    <tr class="tab-row tab-row-clear">
                      <td class="tab-cell" >{{ $tabUE[$i]->code}}</td>
                      <td class="tab-cell" >{{ $tabUE[$i]->libelle}}</td>
                      <td class="tab-cell"> {{ $listeCompetences[$i]->code }} </td>
                      <td class="tab-cell" >{{ $listeCompetences[$i]->libelle }}</td>
                      <td class="tab-cell" >{{ $listeSemestres[$i]->libelle }}</td>
                      <td class="tab-cell" >{{ $listeSemestres[$i]->id_annee }}</td>
                      <td><a class="tab-cell clear-cell button del-button " href="#">Supprimer </a></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
          </div>
        </div>
@endsection
@endsection