<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\Evaluation;
use App\Models\Groupe;
use App\Models\Ressource;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


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
        $tabressources = [];
        $tabMoyennesRessources = [];
        $tabMoyennesCompetences = [];
        foreach($evaluations as $eval) {
            if (!in_array($eval->code_ressource, $tabressources)){
                array_push($tabressources, $eval->code_ressource);
                $tabMoyennesRessources[$eval->code_ressource] = [$this->moyenneParRessource($id, $eval->code_ressource), $eval->ressource->libelle];
            }
        }
        foreach($this->listeCompetences($id) as $comp) {
            $competence = Competence::find($comp);
            $tabMoyennesCompetences[$competence->libelle] = $this->moyenneParCompetence($id, $competence->code);
        }
        $moyenneSemestre = $this->moyenneSemestre($id);
        return view('visuNote', compact('evaluations', 'tabMoyennesRessources', 'tabMoyennesCompetences', 'moyenneSemestre'));
    }
    
    public function evalsEleve($id){

        if (!Gate::allows('isEleve') && !Gate::allows('isAdmin')) {
            abort(403, Gate::allows('Vous ne pouvez pas accéder aux notes'));
        }

        if (!Gate::allows('matchId', $id)){
            abort(403, Gate::allows('Vous ne pouvez regarder que vos notes'));
        }

        $eleve = Utilisateur::find($id);
        $groupe = $eleve->groupe;
        $ressources = $groupe->ressources;
        $evals = [];
        foreach($ressources as $ressource){
            foreach($ressource->evaluations as $eval){
                array_push($evals, $eval);
            }
        }

        return $evals;
    }

    #Retourne toutes les ressources d'un élève
    public function ressourcesEleve($id){

        if (!Gate::allows('isEleve') && !Gate::allows('isAdmin')) {
            abort(403, Gate::allows('Vous ne pouvez pas accéder aux ressources'));
        }

        $eleve = Utilisateur::find($id);
        if ($eleve->isProf == 1){
            return 'ratio';
        }
        return $eleve->groupe->ressources;
    }

    public function moyenneParRessource(string $idEleve, string $idRessource) {
        
        if (!Gate::allows('isEleve') && !Gate::allows('isAdmin')) {
            abort(403, Gate::allows('Vous ne pouvez pas accéder aux notes'));
        }

        $eleve = Utilisateur::find($idEleve);
        $notes = 0;
        $c = 0;
        foreach($eleve->evaluations as $evaluation) {
            if($evaluation->code_ressource == $idRessource){
                $notes += $evaluation->pivot->note * $evaluation->coefficient;
                $c += $evaluation->coefficient;
            }
        }
        if($notes == 0){
            return 'Pas disponible';
        }
        return $notes / $c;
    }

    public function moyenneParCompetence(string $idEleve, string $idCompetence) {
        $competence = Competence::find($idCompetence);
        $notes = 0;
        $c = 0;
        $ressourcesCoef = [];
        $moyRessources = [];
        foreach($competence->ressources as $ressource) {
            $ressourcesCoef[$ressource->code] = $ressource->pivot->coefficient;
            if($this->moyenneParRessource($idEleve, $ressource->code) != 'Pas disponible'){
                $moyRessources[$ressource->code] = $this->moyenneParRessource($idEleve, $ressource->code);
            }
        }
        if(empty($moyRessources)){
            return 'Pas disponible';
        }
        foreach($moyRessources as $key => $valeur){
            $notes += $valeur * $ressourcesCoef[$key];
            $c += $ressourcesCoef[$key];
        }
        if($notes == 0){
            return 'Pas disponible';
        }
        return $notes / $c;
    }

    public function listeCompetences(string $idEleve) {
        $listeRessources = $this->ressourcesEleve($idEleve);
        $listeCompetences = [];
        $tabRessources = [];
        foreach($listeRessources as $ressource){
            array_push($tabRessources, $ressource->code);
        }
        foreach($listeRessources as $ressource) {
            foreach($ressource->competences as $competence) {
                if($competence->pivot->code_ressource != 'BFTM5S01' && $competence->pivot->code_ressource != 'BFTM5R01' && $competence->pivot->code_ressource != 'BFTM5R02' && $competence->pivot->code_ressource != 'BFTM5R03') {
                    if (!in_array($competence->pivot->code_competence, $listeCompetences)){
                        if(in_array($competence->pivot->code_ressource, $tabRessources)){
                            array_push($listeCompetences, $competence->pivot->code_competence);
                        }
                    }
                }
            }
        }
        return $listeCompetences;
    }

    public function moyenneSemestre(string $idEleve) {
        $notes = 0;
        $c = 0;
        foreach($this->listeCompetences($idEleve) as $comp){
            $competence = Competence::find($comp);
            if($this->moyenneParCompetence($idEleve, $competence->code) != 'Pas disponible'){
                $notes += $this->moyenneParCompetence($idEleve, $competence->code);
                $c++;
            }
        }
        if($notes == 0) {
            return 'Pas disponible';
        }
        return $notes / $c;
    }
}
