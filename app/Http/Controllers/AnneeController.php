<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annee;

class AnneeController extends Controller
{
    public function index() {
        $tabAnnees = Annee::paginate(10);
        
        return view('afficherAnnees', compact('tabAnnees'));
    }

    public function create(){
        return view('ajoutAnnee');
    }

    public function store(Request $request){
        
        $customErrorMessages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
            'regex' => 'Le champ :attribute doit contenir au moins une majuscule et un chiffre.',
            'same' => 'Les mots de passe doivent être identiques',
            'unique' => 'Ce code est déja utilisé'
        ];

        $validator =  $request ->validate([
            'adeb'=>['required','numeric','regex:/[0-9]{4}/'],
            'afin'=>['required','numeric','regex:/[0-9]{4}/','gt:adeb']
        ]);

        $id = $request->input('adeb')."-".$request->input('afin');
        $annee = Annee::create([
            "id_annee" => $id,
            "annee_debut"=>$request->input('adeb'),
            "annee_fin"=>$request->input('afin')
        ]);

        return redirect()->route('annees.index')->withErrors($validator);
    }
}