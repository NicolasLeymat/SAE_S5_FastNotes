<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupe;
use App\Models\Parcours;

class GroupeController extends Controller
{
    public function index() {
        $tabGroupes = Groupe::paginate(10);
        
        return view('afficherGroupes', compact('tabGroupes'));
    }

    public function create() {
        $listeParcours = Parcours::all();

        return view ('ajoutGroupe',compact('listeParcours'));
    }

    public function store (Request $request) {
        $customErrorMessages = [
            'required' => 'Le champ :attribute est requis.',
            'max' => 'Le champ :attribute doit contenir au plus :max caractères.',
        ];
        

        $validator =  $request ->validate([
            'libelle' => 'required|string|max:255',
            'parcours'=> 'required|string|max:255'],$customErrorMessages
        );

        $parcours = Parcours::findOrFail($request->input('parcours'));
        $semestre = $parcours->semestre;
        $libelle = $request->input('libelle');

        $numSemestre =  explode(" ",$semestre->libelle)[1];

        $idDB = "inS".$numSemestre."_".$libelle."_".$semestre->id_annee;

        if (!Groupe::where('id',$idDB)->exists()) {
            Groupe::create(["id"=>$idDB,"libelle"=>$libelle,"parcours"=>$request->input("parcours")]);
        }


        return redirect()->route('groupes.index')->withErrors($validator);

    }
}