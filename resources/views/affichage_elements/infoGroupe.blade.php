@extends('layouts.fn')

@section('title', 'Infos groupe '.$groupe->libelle)

@section('content')
<div class ="home_container container grid">
    <div class="home_content">
        <div>
        <h2> Informations sur le groupe {{$groupe->libelle}}</h2>

        <h3> Identifiant du groupe : {{$groupe->id}}</h3>
        </div>
        <div class="items_admin flex_forms">
            <div class="flex_divs_tab">
                <h2> Elèves : </h2>
                    <table class="eleve-tab">
                    <thead class="tab-row-dark">
                    <tr>   
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th></th>
                        <th></th>
                    </tr> 
                    </thead>
                    @for ($i = 0; $i < count($eleves); $i++)
                    <tr class="tab-row tab-row-clear">
                        <td class="tab-cell" >{{ $eleves[$i]->utilisateur->code}}</td>
                        <td class="tab-cell" >{{ $eleves[$i]->utilisateur->nom}}</td>
                        <td class="tab-cell" >{{ $eleves[$i]->utilisateur->prenom}}</td>
                        <td><a class="clear-cell button del-button " href="{{ route('') }}">Supprimer </a> </td>
                    </tr>
                    @endfor
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
<script>
    let rowCounter = 0;
    let compteur = 0;
    let boutonValider = null;
    document.addEventListener('DOMContentLoaded', function() {
        boutonValider = document.getElementById("valider");
        boutonValider.style.display = "none";



    })



    function addRow() {
        var tableau = document.getElementById("enseign_table");
        var ligne = document.querySelector(".ligne_ajout");
        boutonValider.removeAttribute("disabled");
        boutonValider.style.display = "inline-block";

        var nouvelle_ligne = ligne.cloneNode(true);
        var select = nouvelle_ligne.querySelectorAll("select");

        select[0].name = "ressource["+rowCounter+"]";
        select[1].name = "groupe["+rowCounter+"]";
        let cellGroupe = select[1].parentNode.nextElementSibling;
        let cellAnnees = cellGroupe.nextElementSibling;
        let selectedValue = select[1].options[0].innerHTML;
        let tabString = selectedValue.split(" ")
        cellGroupe.innerHTML = tabString[1].split("(")[1]+" "+tabString[2];
        cellAnnees.innerHTML = tabString[3].split(")")[0];

        
        select[1].addEventListener('change',function (event) {
            selectedValue = event.target.options[event.target.selectedIndex].innerHTML;
            console.log("Nouvelle valeur sélectionnée : " + selectedValue);
            tabString = selectedValue.split(" ")
            console.log(tabString[1].split('('));
            cellGroupe.innerHTML = tabString[1].split("(")[1]+" "+tabString[2];
            cellAnnees.innerHTML = tabString[3].split(")")[0];


        })

        console.log(select.name);

        nouvelle_ligne.classList.remove("ligne_ajout");

        tableau.appendChild(nouvelle_ligne);

        rowCounter++;
        compteur++;
    }

    function removeRow(button) {
        const row = button.closest("tr");
        compteur--;
        if (compteur <=0) {
            boutonValider.style.display = "none"
        }
        row.remove();
    }


</script>