<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Utilisateur;
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
    public function show(string $id)
    {
        $evaluation = Evaluation::find($id);
        $eleves = [];
        foreach($evaluation->utilisateurs as $utilisateur){
            if($utilisateur->isProf == 0 && $utilisateur->isAdmin == 0){
                array_push($eleves, $utilisateur);
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
            $this->saisirNote($evalId,$eleveID,$note["note"]);

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
