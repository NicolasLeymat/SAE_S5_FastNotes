<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

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
                array_push($eleves, $utilisateur->pivot->code_eleve);
            }
        }
        return view('evaluation')->with('eleves', $eleves)->with('eval', $evaluation);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
