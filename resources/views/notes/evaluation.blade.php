<script>
    function confirmerSaisie(){
        var nbNotes = 0;
        var nbNotesNonSaisies = 0;
        var saisies = document.querySelectorAll('#formulaireNotes table tr');
        saisies.forEach(function(inputElement, index) {
            if(index!=0){
                var isAbsent = inputElement.querySelector('input[type="checkbox"]').checked;
                var noteInput = inputElement.querySelector('input[type="number"]').value;
                nbNotes+=1;
                if (noteInput == "" && !isAbsent) {
                    nbNotesNonSaisies+=1;
                }
            }
        });

        if (nbNotesNonSaisies==0) {
            document.getElementById('formulaireNotes').submit();
        } else if(nbNotesNonSaisies>1){
            if(confirm(nbNotesNonSaisies+' notes n\'ont pas été saisies. Voulez-vous tout de même enregistrer les notes saisies ?')){
                document.getElementById('formulaireNotes').submit();
            }
        } else {
            if(confirm(nbNotesNonSaisies+' note n\'a pas été saisie. Voulez-vous tout de même enregistrer les notes saisies ?')){
                document.getElementById('formulaireNotes').submit();
            }
        }
    }

    function changertab(){
        var selection = document.getElementById("groupe_select");
        var valeurSelectionnee = selection.value;
        var tab = document.getElementById("saissi_note_tab");
        var rows = tab.getElementsByTagName("tr");
        var groupeCell = document.querySelectorAll("#groupe_Cell");
        var note_input = document.querySelectorAll("#note_input");
        groupeCell.forEach(function(cell, index){
            if(valeurSelectionnee === "Tous"){
                cell.parentElement.style.display = "table-row";
                note_input[index].disabled= false;
            }
            else if(cell.innerText === valeurSelectionnee){
                cell.parentElement.style.display = "table-row";
                note_input[index].disabled = false;
            }else{
                cell.parentElement.style.display = "none";
                note_input[index].disabled = true;
            }
        });
    }
</script>
@extends('layouts.fn')
@section('title', 'Fast Notes')
@section('content')
        <div class="home_container container grid">
        <h2> {{$evaluation['libelle']}} </h2>
        <div class="home_content">
        <select name="groupe_select" id="groupe_select" onchange="changertab()">
            <option value="Tous">Tous</option>
            @foreach($groupe as $groupe_eleve)
            <option value="{{ $groupe_eleve }}">{{ $groupe_eleve }}</option>
            @endforeach
        </select>
        <form action="{{ route('saisir_notes') }}" method="POST" name="formulaire" id="formulaireNotes" class="saissi_notes_form">
            @csrf
            <input type="hidden" name="evaluation_id" value="{{ $evaluation->id }}"> 
            <table class="saissi_note_tab" id="saissi_note_tab">
                <thead>
                    <tr class="tab-row-dark">
                        <th class="tab-cell">Numéro étudiant</th>
                        <th class="tab-cell">Nom</th>
                        <th class="tab-cell">Prenom</th>
                        <th class="tab-cell">Groupe</th>
                        <th class="tab-cell">Note</th>
                        <th class="tab-cell">Absent</th>
                    </tr>
                </thead>
            @foreach($eleves as $eleve)
                <tr>
                    <td class="tab-cell clear-cell">{{$eleve['identification']}}</td>
                    <td class="tab-cell clear-cell">{{$eleve['nom']}}</td>
                    <td class="tab-cell clear-cell">{{$eleve['prenom']}}</td>
                    <td class="tab-cell clear-cell" id="groupe_Cell">{{$eleve['id_groupe']}}</td>
                    <td class="clear-cell"><input id="note_input" class="input" type="number" step="0.001" name="notes[{{ $eleve['code'] }}][note]" value="{{ $eleve['note'] }}" min= 0 max=20 ></td>
                    <td class="tab-cell clear-cell"><input type="checkbox" name="absent" id="isAbsent" class="checkbox_missing"></td>
                </tr>
            @endforeach
            </table>
            <input class="button button_save_notes" type="button" value="Enregistrer les notes" onclick='confirmerSaisie()'>
        </form>
        </div>
        </div>
@endsection
