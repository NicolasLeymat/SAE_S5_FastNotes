<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professeur;
use App\Models\Groupe;
use App\Models\Parcours;
use App\Models\Semestre;

class ProfController extends Controller
{
    public function index(){
        $tabProf = Professeur::paginate(10);
        $listeUtilisateurs = [];
        foreach ($tabProf as $prof) {
           array_push($listeUtilisateurs,$prof->utilisateur) ;
        }
        return view('listeProfs', compact('tabProf','listeUtilisateurs'));
    }
    

    public function show(string $idProf) {

        $prof = Professeur::with('enseignements')->findOrFail($idProf);
        $utilisateur = $prof->utilisateur;
        $enseignements = $prof->enseignements;
        $resListe = [];
        foreach ($enseignements as $enseignement) {
            $groupe = Groupe::findOrFail($enseignement->pivot->id_groupe);
            $parcours = Parcours::findOrFail($groupe->parcours);
            $semestre = $parcours->semestre;
            //dd($semestre);
            array_push($resListe,["nomRessource" => $enseignement["nom"],"groupe" => $groupe->libelle,"semestre"=>$semestre["libelle"],"periode"=>$semestre["id_annee"]]);
        }
        return view ('infoProf',compact('utilisateur','resListe'));

    }
}
