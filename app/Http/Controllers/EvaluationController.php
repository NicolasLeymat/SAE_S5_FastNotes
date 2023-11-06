<?php

namespace App\Http\Controllers;

use App\Imports\EvaluationImport;
use App\Models\Evaluation;
use App\Models\Utilisateur;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Gate;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = DB::table('evaluation')->get()->sortBy('libelle');
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


        
        $ressourceEval = $evaluation->ressource; 
        if (! empty($ressourceEval) ) {
            foreach($ressourceEval->groupes as $groupe){
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
                        
                        $infosEleve = ['nom'=>$eleve->nom, 'identification'=>$eleve->identification, 'prenom'=>$eleve->prenom,'id_groupe'=>$eleve->id_groupe, 'note'=>$note,'code'=>$eleve->code];
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

        if (!Gate::allows('isProf')){
            abort(403, Gate::allows('Vous n\'êtes pas prof'));
        }

        $evaluation = Evaluation::findOrFail($idEval);
        $eleve = Utilisateur::findOrFail($idEleve);


        if ($note >=0 && $note <=20 && $evaluation && $eleve) {
        $evaluation->utilisateurs()->syncWithoutDetaching([
            $idEleve => ['note' => $note]
        ]);
        }
    }

    public function saisirNotes (Request $request) {
        
        if (!Gate::allows('isProf')){
            abort(403, Gate::allows('Vous n\'êtes pas prof'));
        }

        $evalId =$request->input('evaluation_id');
        $notes = $request->input('notes');

        foreach ($notes as $eleveID => $note) {
            //return $note;
            if ($note["note"] !== null) {
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

    public function import(Request $request){   
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            Excel::import( new EvaluationImport(), $request->file("file") );    
            return redirect()->back()->with('success', 'File has been imported successfully.');
        }else{
            return redirect()->back()->with('error', 'Please upload a file.');
        }
    }
}
