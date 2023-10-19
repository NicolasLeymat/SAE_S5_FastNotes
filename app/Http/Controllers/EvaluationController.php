<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Groupe;
use App\Models\Utilisateur;
use App\Models\Parcours;
use Dflydev\DotAccessData\Util;
use Illuminate\Http\Request;
use Validator;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = Evaluation::paginate(10);
        return view('dashprof')->with('evals', $results);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $idEval)
    {
        $evaluation = Evaluation::find($idEval);
        $eleves = [];



        foreach($evaluation->ressource->parcours as $parcoursEval){
            foreach($parcoursEval->groupes as $groupe){
                $groupe = Groupe::find($groupe->id);
                foreach($groupe->utilisateurs as $eleve){


                    if($eleve->isProf == 0 && $eleve->isAdmin == 0){
                        $pivotData = $eleve
                        ->evaluations()
                        ->where('id_evaluation', $idEval)->first();

                        if ($pivotData) {
                            $note = $pivotData->pivot->note;
                        } else {
                            $note = '';
                        }
                        
                        
                        
                        $infosEleve = ['nom'=>$eleve->nom, 'identification'=>$eleve->identification, 'prenom'=>$eleve->prenom, 'note'=>$note,'code'=>$eleve->code];
                        array_push($eleves, $infosEleve);
                    }
                    
                }
            }
        }
                    
                
        
        return view('evaluation',compact('evaluation','eleves'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function saisirNote (string $idEval, string $idEleve, float $note) {
        $evaluation = Evaluation::findOrFail($idEval);
        $eleve = Utilisateur::findOrFail($idEleve);


        if ($note >=0 && $note <=20) {
        $evaluation->utilisateurs()
        ->updateExistingPivot($idEleve, ['note' => $note]);
        }
    }

    public function saisirNotes (Request $request) {
        
        $evalId =$request->input('evaluation_id');
        $notes = $request->input('notes');

        foreach ($notes as $eleveID => $note) {
            if ($note != null) {
                $this->saisirNote($evalId,$eleveID,$note["note"]);
            }

        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
