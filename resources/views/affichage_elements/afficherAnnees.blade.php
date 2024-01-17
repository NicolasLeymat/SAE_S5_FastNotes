@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
            <table class="eleve-tab">
                <thead class="tab-row-dark">
                  <tr>   
                    <th>Année</th>
                    <th>Debut</th>
                    <th>Fin</th>
                    <th></th>
                  </tr> 
                </thead>
                @for ($i = 0; $i < count($tabAnnees); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabAnnees[$i]->id_annee}}</td>
                    <td class="tab-cell" >{{ $tabAnnees[$i]->annee_debut}}</td>
                    <td class="tab-cell" >{{ $tabAnnees[$i]->annee_fin}}</td>   
                    <form method="post" action = "{{route ('supprimerAnnee', ['annee'=>$tabAnnees[$i]->id_annee]) }}">
                      @csrf
                      @method('DELETE')
                      <td class=" "><button class="clear-cell button del-button " type="submit">Supprimer </button> </td>
                    </form>  

                  </tr>
                @endfor
            </table>
          </div>
@endsection