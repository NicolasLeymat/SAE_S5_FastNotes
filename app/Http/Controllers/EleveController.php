<?php

namespace App\Http\Controllers;

use App\Imports\ElevesImport;
use App\Models\Evaluation;
use App\Models\Ressource;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $m = $this->moyenneParRessource($id, 'BFTA5R01');
        $tabressources = [];
        $tabmoyennes = [];
        foreach($evaluations as $eval) {
            if (!in_array($eval->code_ressource, $tabressources)){
                array_push($tabressources, $eval->code_ressource);
                $tabmoyennes[$eval->code_ressource] = [$this->moyenneParRessource($id, $eval->code_ressource), $eval->ressource->libelle];
            }
        }
        
        return view('visuNote', compact('evaluations', 'tabmoyennes'));
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

    public function import(Request $request){
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            //dd($request);
            Excel::import(new ElevesImport, $request->file('file'));
    
            // You can add more logic here after importing the file.
    
            return redirect()->back()->with('success', 'File has been imported successfully.');
        }else{
            dd($request);
            return redirect()->back()->with('error', 'Please upload a file.');
        }
    }
}
