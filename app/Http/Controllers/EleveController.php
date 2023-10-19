<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;


class EleveController extends Controller
{
    #Retourne toutes les évaluations d'un élève
    public function index(){
        $result = Utilisateur::paginate(10);
        return view('visuNote', $result);
    }

    public function show(string $id){
        $evaluations = $this->evalsEleve($id);
        return view('visuNote', compact('evaluations'));
    }
    
    public function evalsEleve($id){
        $eleve = Utilisateur::find($id);
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
