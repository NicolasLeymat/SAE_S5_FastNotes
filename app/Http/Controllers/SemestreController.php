<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SemestreController extends Controller
{
    public function index(){
        $tabSemestres = Semestre::paginate(10);
        
        return view('affichage_elements.afficherSemestres', compact('tabSemestres'));
    }

    public function create() {
        $listeAnnees = Annee::all();

        return view('ajouts.ajoutSemestre',compact('listeAnnees'));
    }

    public function store(Request $request) {
        
        $customErrorMessages = [
            'unique' => 'Le semestre existe déjà'
        ];

        $id_semestre = $request->numero . "_" . $request->annee;
        $request->merge(['id_semestre'=>$id_semestre]);

        $validator =  $request ->validate([
            'numero' => ['required', 'integer', 'between:1,6'],
            'annee' => [
                'required',
                'string',
                'regex:/^\d{4}-\d{4}$/',
            ],
            'id_semestre' => 'required|unique:semestres',
        ], $customErrorMessages
        );

        $annee_verif = Annee::findOrFail($request->input('annee'));

        $libelle = "Semestre " . $request->numero;

        $semestre = Semestre::create(['id_semestre'=>$id_semestre,
        'libelle'=>$libelle,
        'id_annee'=>$annee_verif->id_annee]);

        return redirect()->route('semestre.index')->withErrors($validator);

    }

    public function destroy(UE $ue) {
        //...
    }
}
