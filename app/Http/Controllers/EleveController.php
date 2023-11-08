<?php

namespace App\Http\Controllers;

use App\Imports\ElevesImport;
use App\Models\Competence;
use Hash;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
use App\Models\Ressource;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;


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
        $evalsnotees = $user->evaluations;
        $tabNotes = [];
        foreach($evalsnotees as $evalnotee){
            array_push($tabNotes, $evalnotee);
        }
        $tabressources = [];
        $tabMoyennesRessources = [];
        $tabMoyennesCompetences = [];
        foreach($evaluations as $eval) {
            if (!in_array($eval->code_ressource, $tabressources)){
                $ressource = Ressource::find($eval->code_ressource);
                array_push($tabressources, $eval->code_ressource);
                $tabMoyennesRessources[$eval->code_ressource] = [$this->moyenneParRessource($user, $ressource), $ressource->libelle];
            }
        }
        
        foreach($this->listeCompetences($user) as $comp) {
            $competence = Competence::find($comp);
            $tabMoyennesCompetences[$competence->libelle] = $this->moyenneParCompetence($user, $competence);
        }
        
        //$moyenneSemestre = $this->moyenneSemestre($id);
        $moyenneSemestre = 4;
        return view('visuNote', compact('evaluations', 'tabNotes', 'tabMoyennesRessources', 'tabMoyennesCompetences', 'moyenneSemestre'));
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
    public function ressourcesEleve(Utilisateur $eleve){

        if (!Gate::allows('isEleve') && !Gate::allows('isAdmin')) {
            abort(403, Gate::allows('Vous ne pouvez pas accéder aux ressources'));
        }

        
        if ($eleve->isProf == 1){
            return 'ratio';
        }
        return $eleve->groupe->ressources;
    }

    public function moyenneParRessource(Utilisateur $eleve, Ressource $ressource) {
        
        if (!Gate::allows('isEleve') && !Gate::allows('isAdmin')) {
            abort(403, Gate::allows('Vous ne pouvez pas accéder aux notes'));
        }

        $notes = 0;
        $c = 0;
        foreach($eleve->evaluations as $evaluation) {
            if($evaluation->code_ressource == $ressource->code){
                $notes += $evaluation->pivot->note * $evaluation->coefficient;
                $c += $evaluation->coefficient;
            }
        }
        if($notes == 0){
            return 'Pas disponible';
        }
        return $notes / $c;
    }

    public function moyenneParCompetence(Utilisateur $eleve, Competence $competence) {
        $notes = 0;
        $c = 0;
        $ressourcesCoef = [];
        $moyRessources = [];
        foreach($competence->ressources as $ressource) {
            $ressourcesCoef[$ressource->code] = $ressource->pivot->coefficient;
            if($this->moyenneParRessource($eleve, $ressource) != 'Pas disponible'){
                $moyRessources[$ressource->code] = $this->moyenneParRessource($eleve, $ressource);
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

    public function listeCompetences(Utilisateur $idEleve) {
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
        $eleve = Utilisateur::findOrFail($idEleve);

        foreach($this->listeCompetences($eleve) as $comp){
            $competence = Competence::find($comp);
            if($this->moyenneParCompetence($eleve, $competence) != 'Pas disponible'){
                $notes += $this->moyenneParCompetence($eleve, $competence);
                $c++;
            }
        }
        
        if($notes == 0) {
            return 'Pas disponible';
        }
        return $notes / $c;
    }

    public function addManyStudents(Request $request){
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            //dd($request);
            Excel::import(new ElevesImport, $request->file('file'));
    
            // You can add more logic here after importing the file.
    
            return redirect()->back()->with('successManyEleves', 'Les élèves ont été ajoutés avec succés');
        }else{
            return redirect()->back()->with('error', 'Please upload a file.');
        }
    }

    public function addOneStudent(Request $request){
        //dd($request->groupe);
        Utilisateur::create([
            'code'=> $request->code,
            'identification'=>$request->identifiant,
            'nom'=>$request->nom,
            'prenom'=>$request->prenom,
            'email'=>$request->email,
            'password'=> Hash::make($request->nom.$request->prenom.$request->groupe),
            'isProf' => 0,
            'isAdmin' => 0,
            'id_groupe'=> $request->groupe
        ]);
        return redirect()->back()->with('successOneEleves','L\'élève a été ajouté avec succés');
    }
}
