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
        setlocale(LC_ALL, 'fr_FR.utf8');



        $evaluations = $this->evalsEleve($id);
        $user = Utilisateur::find($id);
        $tabNotes = [];
        $tabressources = [];
        $tabMoyennesRessources = [];
        $tabCoefsRessources = [];
        foreach($evaluations as $evalnotee){
            $coefficient = $evalnotee->coefficient;
            
            if (!in_array($evalnotee->code_ressource, $tabressources)){
                array_push($tabressources, $evalnotee->code_ressource);
                $tabCoefsRessources[ $evalnotee->code_ressource]= 0;
                $tabMoyennesRessources[$evalnotee->code_ressource] = [$evalnotee->ressource->libelle,0]; 
            }
            $noteExists = $user->evaluations()->wherePivot('id_evaluation', $evalnotee->id)->exists();
            if ($noteExists) {
                $note = $user->evaluations()->wherePivot('id_evaluation', $evalnotee->id)->first()->pivot->note;
                $tabMoyennesRessources[$evalnotee->code_ressource][1] += $note * $coefficient; 
                $tabCoefsRessources[ $evalnotee->code_ressource] += $evalnotee->coefficient;
            }
            else {
                $note = "Pas disponible";
            }
            $tabNotes[$evalnotee->id] = [ "code_ressource"=>$evalnotee->code_ressource, "libelle"=>$evalnotee->libelle, "type"=>$evalnotee->type, "note"=>$note ];
        }
         
        foreach ($tabMoyennesRessources as $ressource=>$valeur) {
            
            $coef = $tabCoefsRessources[$ressource];
            
            if ($coef == 0) {
                $tabMoyennesRessources[$ressource][1] = "Pas disponible";
            }
            else {
                $tabMoyennesRessources[$ressource][1] /= $tabCoefsRessources[$ressource];
            }
        }
        $tabMoyennesCompetences = [];
        $nbComp = 0;
        //dd ($this->listeCompetences($user));
        foreach($this->listeCompetences($user) as $comp) {
            $competence = Competence::find($comp);
            $hasNote = false;
            $moyenneCompetences = 0;
            $coefTotal = 0;
            $ressourcesConcernes = $competence->ressources;
            foreach ($ressourcesConcernes as $ressource) {
                $coefRessourceCompetence = $ressource->pivot->coefficient;
                if (!empty($tabMoyennesRessources[$ressource->code]) && $tabMoyennesRessources[$ressource->code][1] != "Pas disponible" && $coefRessourceCompetence!=0 ) {
                $coefTotal += $coefRessourceCompetence;
                $moyenneCompetences += $tabMoyennesRessources[$ressource->code][1] * $coefRessourceCompetence;
                $hasNote = true;
                }
            }
            if ($hasNote) {
                $moyenneCompetences/=$coefTotal;
                $tabMoyennesCompetences[$competence->libelle] = $moyenneCompetences;
                $nbComp++;
            }
            else {
                $tabMoyennesCompetences[$competence->libelle] ="Pas disponible";
            }
        }
        
        if ($nbComp != 0) {
            $moyenneSemestre = array_sum($tabMoyennesCompetences)/$nbComp;
        }
        else {
            $moyenneSemestre = "Pas Disponible";
        }
        
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
        ([$groupe->id,$ressources]);
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
