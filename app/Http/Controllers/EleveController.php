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
    private $tabNotes = [];
    private $tabCompetences = [];
    private $tabMoyennesCompetences = [];
    private $tabMoyennesRessources = [];
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
        foreach($this->tabCompetences as $competence){
            $this->tabMoyennesCompetences[$competence->libelle] = $this->moyenneParCompetence($competence);
        }
        $moyenneSemestre = $this->moyenneSemestre();

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

    public function moyenneParCompetence($competence) {
        $notes = 0;
        $c = 0;
        $ressourcesCoef = [];
        foreach($competence->ressources as $ressource) {
            $ressourcesCoef[$ressource->code] = $ressource->pivot->coefficient;
        }
        foreach($ressourcesCoef as $key => $valeur){
            if($this->tabMoyennesRessources[$key][1] != "Pas disponible"){
                $notes += $valeur * $this->tabMoyennesRessources[$key][1];
                $c += $valeur;
            }
        }
        if($notes == 0){
            return 'Pas disponible';
        }
        return $notes / $c;
    }

    public function listeCompetences() {
        $ueCompta = [];
        foreach($this->tabRessources as $ressource) {
            foreach($ressource->ue as $competence) {
                if($competence->pivot->code_ressource != 'BFTM5S01' && $competence->pivot->code_ressource != 'BFTM5R01' && $competence->pivot->code_ressource != 'BFTM5R02' && $competence->pivot->code_ressource != 'BFTM5R03') {
                    if (!in_array($competence->code, $ueCompta)){
                        if($this->tabRessources->contains($competence->pivot->code_ressource)){
                            array_push($this->tabCompetences, $competence);
                            array_push($ueCompta, $competence->code);
                        }
                    }
                }
            }
        }
    }

    public function moyenneSemestre() {
        $notes = 0;
        $c = 0;

        foreach($this->tabCompetences as $competence){
            if($this->tabMoyennesCompetences[$competence->libelle] != 'Pas disponible'){
                $notes += $this->tabMoyennesCompetences[$competence->libelle];
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
            $this->tabMoyennesRessources[$ressource->code] = [$ressource->nom,0];
        }
        foreach($this->user->evaluations as $eval){
            if($eval->pivot->note == null){
                $this->tabNotes[$eval->id] = [ "code_ressource"=>$eval->code_ressource, "libelle"=>$eval->libelle, "type"=>$eval->type, "note"=>"Pas disponible"];
            }else{
                $this->tabNotes[$eval->id] = [ "code_ressource"=>$eval->code_ressource, "libelle"=>$eval->libelle, "type"=>$eval->type, "note"=>$eval->pivot->note ];
            }
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

    public function afficherEleves(){
        $tabEleves = Eleve::paginate(10);
        $listeGroupes = [];
        foreach ($tabEleves as $Eleves) {
           array_push($listeGroupes,$Eleves->groupe) ;
        }
        
        return view('afficherEleves', compact('tabEleves','listeGroupes'));
    }



}
