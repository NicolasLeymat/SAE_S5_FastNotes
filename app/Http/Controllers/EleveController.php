<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;


class EleveController extends Controller
{
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

}
