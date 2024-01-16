<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semestre;
use App\Models\Parcours;

class ParcoursController extends Controller
{
    public function index() {
        $tabParcours = Parcours::paginate(10);
        $listeSemestres = [];
        foreach ($tabParcours as $parcours) {
            array_push($listeSemestres,$parcours->semestre);
            
        }
        return view('affichage_elements.afficherParcours', compact('tabParcours','listeSemestres'));
    }

    public function create() {
        $listeSemestres = Semestre::all();

        return view('ajouts.ajoutParcours',compact('listeSemestres'));
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
            'id' => 'required|string|max:255',
            'semestre'=>'required|string|max:255'],
            $customErrorMessages
        );

        $parcours = Parcours::create(['id_parcour' => $request->input('id'), 'id_semestre' => $request->input('semestre')]);

        return redirect()->route('parcours.index')->withErrors($validator);
    }
}