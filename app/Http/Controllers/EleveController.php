<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Ressource;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\DB;


class EleveController extends Controller
{

    //public function show($id) {note_evaluation
        //$user = Utilisateur::find($id);
        //$m = $this->moyenneParRessource($id, 'BFTA5R01');
        //return view('test')->with('m', $m);
    //}
    #Retourne toutes les évaluations d'un élève
    public function index(){
        $result = Utilisateur::paginate(10);
        return view('visuNote', $result);
    }

    public function show(string $id){
        $evaluations = $this->evalsEleve($id);
        $user = Utilisateur::find($id);
        $m = $this->moyenneParRessource($id, 'BFTA5R01');
        return view('visuNote', compact('evaluations', 'm'));
    }
    
    public function evalsEleve($id){
        $data = DB::table('note_evaluation')
        ->join('evaluation', 'note_evaluation.id_evaluation', '=', 'evaluation.id')
        ->select('note_evaluation.*', 'evaluation.*')
        ->where('note_evaluation.code_eleve', $id)
        ->get();
        return $data;
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
