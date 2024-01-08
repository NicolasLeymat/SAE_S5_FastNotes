@extends('layouts.fn')

@section('title', 'Liste des professeurs')

@section('content')
        <div class="home_container container grid">
          <div class="home_content">
            <table class="prof-tab note-tab">
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>email</th>
                </tr>

                @foreach ($listeUtilisateurs as $prof)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $prof["code"] }}</td>
                    <td class="tab-cell "> {{ $prof["nom"] }} </td>
                    <td class="tab-cell" >{{ $prof["prenom"] }}</td>
                    <td class="tab-cell "> {{ $prof["email"] }} </td>
                    <td class="tab-cell">
                    <button class="tab-cell clear-cell del-button" onclick="window.location.href='{{ route('profs.show', $prof['code']) }}'">Afficher informations</button>
                    </td>                    
                    <td class="tab-cell "><button class="tab-cell clear-cell del-button " onclick="window.location.href='#'">Supprimer </button> </td>
                  </tr>
                @endforeach
            </table>
          </div>
        </div>
@endsection
@endsection