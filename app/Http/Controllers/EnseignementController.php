<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enseignement;
use App\Models\Parcours;
use App\Models\Professeur;
use Illuminate\Validation\Rule;

class EnseignementController extends Controller
{
    public function index() {
        $tabEnseignements = Enseignement::paginate(10);
        
        return view('afficherEnseignements', compact('tabEnseignements'));
    }

    public function ajouterEnseignements (Request $request) {
        $ressources = $request->input('ressource', []);
        $groupes = $request->input('groupe',[]);
        $prof = Professeur::findOrFail($request->input('professeur'));

        $customErrorMessages = [
            'exists' => "Ce :attribute n'existe pas"
        ];

        $validator =  $request ->validate([
            'groupe'=> 'required|exists:groupes,id',
            'professeur'=>'required|exists:professeurs,code',
            'ressource' => [
                'required',
                Rule::unique('enseignements',"code_ressource")->where(function ($query) use ($request) {
                    return $query->where('id_groupe', $request->input('groupe'))
                        ->where('code_prof', $request->input('professeur'))
                        ->where('code_ressource', $request->input('ressource'));
                }),
            ],
            
        ]
        );



        foreach ($ressources as $index=>$ressource) {
            if (isset ($groupes[$index])) {
                Enseignement::create(["code_prof"=>$request->input('professeur'),
                "id_groupe"=>$groupes[$index],
                "code_ressource"=>$ressource]);
            }
        }

        return redirect()->back()->withErrors($validator);
    }
}