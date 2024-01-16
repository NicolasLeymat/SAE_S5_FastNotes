<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupe;
use App\Models\Parcours;
use App\Models\Eleve;
use DB;

class GroupeController extends Controller
{
    public function index() {
        $tabGroupes = Groupe::paginate(10);
        
        return view('affichage_elements.afficherGroupes', compact('tabGroupes'));
    }

    public function create() {
        $listeParcours = Parcours::all();

        return view ('ajouts.ajoutGroupe',compact('listeParcours'));
    }

    public function infoGroupe(Request $request){
        //A recup : Liste des eleves, Liste des 
        
        $groupes = Groupe::find($request->groupe);
        $elevesNonGroupe = Eleve::where('id_groupe', '!=', $request->groupe)->orWhereNull('id_groupe')->get();
        $eleves = $groupes->eleves;
        return view('affichage_elements.infoGroupe', compact('groupes','eleves', 'elevesNonGroupe'));
    }

    public function delElevesFromGroupes(Request $request){
        $id_eleve = $request->id_eleve;
        $eleve = Eleve::find($id_eleve);
        $eleve->id_groupe = null;
        $eleve->save();
        return redirect()->back()->with('message', 'Suppression effectuée avec succès.');
    }
}