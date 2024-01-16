@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
          <div class="home_content">
            <table class="prof-tab note-tab">
                <tr>
                    <th>Evaluation</th>
                    <th>Coefficient</th>
                    <th>Type</th>
                    <th>Date epreuve</th>
                    <th>Date rattrapage</th>
                    <th>Code resource</th>
                    
                </tr>
                @for ($i = 0; $i < count($tabEvals); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabEvals[$i]->libelle}}</td>
                    <td class="tab-cell" >{{ $tabEvals[$i]->coefficient }}</td>
                    <td class="tab-cell "> {{ $tabEvals[$i]->type }} </td>
                    <td class="tab-cell" >{{ $tabEvals[$i]->date_epreuve }}</td>
                    <td class="tab-cell" >{{ $tabEvals[$i]->date_rattrapage }}</td>
                    <td class="tab-cell" >{{ $tabEvals[$i]->code_resource }}</td>
                    <td class="tab-cell "><button class="tab-cell clear-cell del-button " onclick="window.location.href='#'">Supprimer </button> </td>
                  </tr>
                @endfor
            </table>
            {{$tabEvals->links('vendor.pagination.simple-default')}}
          </div>
        </div>
@endsection