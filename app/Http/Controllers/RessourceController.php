<?php

namespace App\Http\Controllers;

use App\Models\UE;
use Illuminate\Http\Request;
use App\Models\Ressource;


class RessourceController extends Controller
{
    public function index() {
        $tabRessources = Ressource::paginate(10);
        return view('afficherRessources', compact('tabRessources'));
    }

    public function create(){
        $listeCompetences = UE::all();
        return view('ajoutRessource', compact('listeCompetences'));
    }

    public function store(Request $request) {
        
        $customErrorMessages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
            'regex' => 'Le champ :attribute doit contenir au moins une majuscule et un chiffre.',
            'same' => 'Les mots de passe doivent être identiques',
            'unique' => 'Ce code est déja utilisé'
        ];

        $validator =  $request ->validate([
            'code' => 'required|string|max:255',
            'libelle' => 'required|string|max:255',
            'competence'=> 'required|string|max:255',
            'coef'=>'required|numeric|min:0|max:1'
        ]);

        $ressource = Ressource::create([
            'code' => $request->input('code'),
            'libelle' => $request->input('libelle')
        ]);
        $ue = UE::find($request->input('competence'));
        
        //"coefficient_ue", "code_ressource", "code_ue"
        $coef_UE = $ressource->ue()->attach($ue,[
            'code_ressource'=> $request->input('code'),
            'code_ue'=> $request->input('competence'),
            'coefficient'=> $request->input('coef')
        ]);

        return redirect()->route('ressource.index')->withErrors($validator);
    }
}