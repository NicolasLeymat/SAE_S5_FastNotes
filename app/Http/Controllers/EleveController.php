<?php

namespace App\Http\Controllers;

use App\Imports\ElevesImport;
use App\Models\Competence;
use App\Models\Eleve;
use App\Models\UE;
use Hash;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
use App\Models\Ressource;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;


class EleveController extends Controller
{

    private $tabRessources;
    private $tabNotes;
    private $tabCompetences = [];
    private $tabMoyennesCompetences = [];
    private $tabMoyennesRessources = [];
    private $tabCoefsRessources;
    private $user;
    private $tabEvaluations = [];

    #Retourne toutes les évaluations d'un élève
    public function index(){
        $result = Utilisateur::paginate(10);
        return view('visuNote', $result);
    }

    public function show(string $id){
        setlocale(LC_ALL, 'fr_FR.utf8');
        $this->user = Eleve::find($id);
        $this->initializeInfosEleves();
        foreach($this->tabRessources as $ressource){
            $this->tabMoyennesRessources[$ressource->code][1]=$this->moyenneParRessource($ressource);
        }
        dd($this->tabMoyennesRessources);
        foreach($this->tabEvaluations as $eval){
            $coefficient = $eval->coefficient;
            if ($this->user->evaluations()->wherePivot('id_evaluation', $eval->id)->exists()) {
                $note = $this->user->evaluations()->wherePivot('id_evaluation', $eval->id)->first()->pivot->note;
                $this->tabMoyennesRessources[$eval->code_ressource][1] += $note * $coefficient; 
                $this->tabCoefsRessources[ $eval->code_ressource] += $eval->coefficient;
            }
            else {
                $note = "Pas disponible";
            }
            $this->tabNotes[$eval->id] = [ "code_ressource"=>$eval->code_ressource, "libelle"=>$eval->libelle, "type"=>$eval->type, "note"=>$note ];
        }
        
        foreach ($this->tabMoyennesRessources as $ressource=>$valeur) {
            
            $coef = $this->tabCoefsRessources[$ressource];
            
            if ($coef == 0) {
                $this->tabMoyennesRessources[$ressource][1] = "Pas disponible";
            }
            else {
                $this->tabMoyennesRessources[$ressource][1] /= $this->tabCoefsRessources[$ressource];
            }
        }
        $nbComp = 0;
        foreach($this->tabCompetences as $competence) {
            $hasNote = false;
            $moyenneCompetences = 0;
            $coefTotal = 0;
            $ressourcesConcernes = $competence->ressources;
            foreach ($ressourcesConcernes as $ressource) {
                $coefRessourceCompetence = $ressource->pivot->coefficient;
                if (!empty($this->tabMoyennesRessources[$ressource->code]) && $this->tabMoyennesRessources[$ressource->code][1] != "Pas disponible" && $coefRessourceCompetence!=0 ) {
                $coefTotal += $coefRessourceCompetence;
                $moyenneCompetences += $this->tabMoyennesRessources[$ressource->code][1] * $coefRessourceCompetence;
                $hasNote = true;
                }
            }
            if ($hasNote) {
                $moyenneCompetences/=$coefTotal;
                $this->tabMoyennesCompetences[$competence->libelle] = $moyenneCompetences;
                $nbComp++;
            }
            else {
                $this->tabMoyennesCompetences[$competence->libelle] ="Pas disponible";
            }
        }
        
        if ($nbComp != 0) {
            $moyenneSemestre = array_sum($this->tabMoyennesCompetences)/$nbComp;
        }
        else {
            $moyenneSemestre = "Pas Disponible";
        }
        return view('visuNote')->with('tabEvaluations',$this->tabEvaluations)->with('tabNotes',$this->tabNotes)->with('tabMoyennesRessources',$this->tabMoyennesRessources)->with('tabMoyennesCompetences',$this->tabMoyennesCompetences)->with('moyenneSemestre',$moyenneSemestre);
    }
    
    public function ressourcesEleve(){
        $groupe = $this->user->groupe;
        $this->tabRessources = $groupe->ressources;
    }

    public function evalsEleve(){

        if (!Gate::allows('isEleve') && !Gate::allows('isAdmin')) {
            abort(403, Gate::allows('Vous ne pouvez pas accéder aux notes'));
        }

        if (!Gate::allows('matchId', $this->user->identification)){
            abort(403, Gate::allows('Vous ne pouvez regarder que vos notes'));
        }

        foreach($this->tabRessources as $ressource){
            foreach($ressource->evaluations as $eval){
                array_push($this->tabEvaluations, $eval);
            }
        }
    }

    public function moyenneParRessource(Ressource $ressource) {
        
        if (!Gate::allows('isEleve') && !Gate::allows('isAdmin')) {
            abort(403, Gate::allows('Vous ne pouvez pas accéder aux notes'));
        }

        $notes = 0;
        $c = 0;
        foreach($this->user->evaluations as $evaluation) {
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

    public function moyenneParCompetence(Competence $competence) {
        $notes = 0;
        $c = 0;
        $ressourcesCoef = [];
        $moyRessources = [];
        foreach($competence->ressources as $ressource) {
            $ressourcesCoef[$ressource->code] = $ressource->pivot->coefficient;
            if($this->moyenneParRessource($ressource) != 'Pas disponible'){
                $moyRessources[$ressource->code] = $this->moyenneParRessource($ressource);
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

    public function listeCompetences() {
        foreach($this->tabRessources as $ressource) {
            foreach($ressource->ue as $competence) {
                if($competence->pivot->code_ressource != 'BFTM5S01' && $competence->pivot->code_ressource != 'BFTM5R01' && $competence->pivot->code_ressource != 'BFTM5R02' && $competence->pivot->code_ressource != 'BFTM5R03') {
                    if (!in_array($competence->pivot->code_ue, $this->tabCompetences)){
                        if($this->tabRessources->contains($competence->pivot->code_ressource)){
                            array_push($this->tabCompetences, $competence);
                        }
                    }
                }
            }
        }
    }

    public function moyenneSemestre() {
        $notes = 0;
        $c = 0;

        foreach($this->tabCompetences as $comp){
            $competence = Competence::find($comp);
            if($this->moyenneParCompetence($competence) != 'Pas disponible'){
                $notes += $this->moyenneParCompetence($competence);
                $c++;
            }
        }
        
        if($notes == 0) {
            return 'Pas disponible';
        }
        return $notes / $c;
    }

    public function initializeInfosEleves(){
        $this->ressourcesEleve();
        $this->evalsEleve();
        $this->listeCompetences();
        foreach($this->tabRessources as $ressource){
            $this->tabCoefsRessources[$ressource->code]= 0;
            $this->tabMoyennesRessources[$ressource->code] = [$ressource->nom,0];
        }
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
