<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Ressource;
use Illuminate\Http\Request;
use App\Models\Utilisateur;


class EleveController extends Controller
{

    public function show($id) {
        $user = Utilisateur::find($id);
        $m = $this->moyenneParRessource($id, 'BFTA5R01');
        return view('test')->with('m', $m);
    }
    #Retourne toutes les évaluations d'un élève
    public function evalsEleve($id){
        $eleve = Utilisateur::find($id);
        if ($eleve->isProf == 1){
            return 'ratio';
        }
        return $eleve->evaluations;

    }

    #Retourne toutes les ressources d'un élève
    public function ressourcesEleve($id){
        $eleve = Utilisateur::find($id);
        if ($eleve->isProf == 1){
            return 'ratio';
        }
        return $eleve->groupe->parcours->ressources;

    }

    public function moyenneParRessource(string $idEleve, string $idRessource) {
        $eleve = Utilisateur::find($idEleve);
        $notes = 0;
        $c = 0;
        foreach($eleve->evaluations as $evaluation) {
            if($evaluation->code_ressource == $idRessource){
                $notes += $evaluation->pivot->note * $evaluation->coefficient;
                $c += $evaluation->coefficient;
            }
        }
        return $notes / $c;
    }
}
