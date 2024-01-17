<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupe;
use App\Models\Parcours;
use App\Models\Eleve;
use App\Models\Ressource;
use App\Models\Professeur;
use App\Models\Enseignement;
use DB;
use App\Imports\GroupeImport;
use Excel;

class GroupeController extends Controller
{
    public function index() {
        $tabGroupes = Groupe::paginate(10);
        
        return view('affichage_elements.afficherGroupes', compact('tabGroupes'));
    }

    public function destroy(Request $request) {
        $groupeId = $request->input('groupe');

        $groupe = Groupe::findOrFail($groupeId);

        foreach($groupe->eleves as $eleve){
            $eleve->id_groupe = null;
            $eleve->save();
        }

        $req = DB::table('enseignements')
        ->where('id_groupe',$groupeId)
        ->delete();

        $req = DB::table('ressource_groupe')
        ->where('id_groupe',$groupeId)
        ->delete();

        $groupe->delete();

        return redirect()->back()->with('message', 'Suppression effectuée avec succès.');
    }

    public function create() {
        $listeParcours = Parcours::all();

        return view ('ajouts.ajoutGroupe',compact('listeParcours'));
    }

    public function infoGroupe(Request $request){
        //A recup : Liste des eleves, Liste des 
        
        $groupes = Groupe::find($request->groupe);
        $ressources = $groupes->ressource;
        //
        $AllRessource = Ressource::all();
        $profs = Professeur::all();
        $ressourceNonGroupe = [];
        foreach($AllRessource as $ressource){
            $enseignements = $ressource->enseignements;
            if($enseignements != null){
                foreach($enseignements as $enseignement){
                    if ($enseignement->id_groupe == $request->groupe){
                        break;
                    }else{
                        array_push($ressourceNonGroupe, $ressource);
                    }
                }
            }
        }
        $elevesNonGroupe = Eleve::where('id_groupe', '!=', $request->groupe)->orWhereNull('id_groupe')->get();
        $eleves = $groupes->eleves;
        return view('affichage_elements.infoGroupe', compact('groupes','eleves', 'elevesNonGroupe', 'ressources', 'ressourceNonGroupe','profs'));
    }

    public function delElevesFromGroupes(Request $request){
        $id_eleve = $request->id_eleve;
        $eleve = Eleve::find($id_eleve);
        $eleve->id_groupe = null;
        $eleve->save();
        return redirect()->back()->with('message', 'Suppression effectuée avec succès.');
    }    
    public function delRessourceFromGroupes(Request $request){
        $groupeId = $request->groupeId;
        $ressourceCode= $request->id_ressource;
        $req = DB::table('enseignements')
        ->where('id_groupe', $groupeId)
        ->where('code_ressource', $ressourceCode)
        ->delete();
        return redirect()->back()->with('message', 'Suppression effectuée avec succès.');
    }

    public function addEleveToGroupe(Request $request){
        $code_eleve = $request->post('eleves');
        $eleve = Eleve::find($code_eleve);
        $eleve->id_groupe = $request->post('groupe_id');
        $eleve->save();
        return redirect()->back()->with('message','Ajout de l\'élève au groupe avec succès');
    }

    public function addRessourceToGroupe(Request $request){
        $code_prof = $request->post('prof');
        $code_ressource = $request->post('ressource');
        $id_groupe= $request->post('groupe_id');
        $enseignement = Enseignement::create(
            ['code_prof'=>$code_prof,
            'code_ressource'=>$code_ressource,
            'id_groupe'=>$id_groupe]
        );
        return redirect()->back()->with('message','Ajout de l\'élève au groupe avec succès');
    }

    public function import(Request $request){   
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            Excel::import(new GroupeImport, $request->file('file'));
    
            // You can add more logic here after importing the file.
    
            return redirect()->back()->with('successManyRessources', 'Les ressources ont été ajoutées avec succès');
        }else{
            return redirect()->back()->with('error', 'Please upload a file.');
        }
    }
}