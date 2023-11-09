<?php

namespace App\Http\Controllers;

use Amenadiel\JpGraph\Graph\PieGraph;
use Amenadiel\JpGraph\Plot\PiePlot;
use App\Imports\EvaluationImport;
use App\Models\Eleve;
use App\Models\Enseignement;
use App\Models\Evaluation;
use App\Models\Professeur;
use App\Models\Utilisateur;
use Auth;
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
<<<<<<< HEAD
        
        $results = DB::table('evaluation')->get()->sortBy('libelle');
=======
        $user = Professeur::find(Auth::user()->code);
        $ressources = $user->ressource->unique();
        $results = [];
        foreach ($ressources as $ressource){
            $evals = DB::table('evaluations')->distinct()->where('code_ressource',$ressource->code)->get();
            foreach($evals as $eval){
                array_push($results, $eval);
            }
        }
>>>>>>> cf7e4a9ebe9909a80843bcdbfa35b72b81b1bd71
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
        $graphique = new PieGraph(350, 250);
        $graphique->title->Set("A Simple Pie Plot");
        $graphique->SetBox(true);

        $data = array(40, 21, 17, 14, 23);
        $p1   = new PiePlot($data);
        $p1->ShowBorder();
        $p1->SetColor('black');
        $p1->SetSliceColors(array('#1E90FF', '#2E8B57', '#ADFF2F', '#DC143C', '#BA55D3'));

        $graphique->Add($p1);
        if(file_exists(public_path().'\images\graph'.$idEval.'.jpg')) {
            unlink(public_path().'\images\graph'.$idEval.'.jpg');
        }
        $graph = $graphique->Stroke(public_path().'\images\graph'.$idEval.'.jpg');

        $evaluation = Evaluation::find($idEval);
        $eleves = [];
        $code_user = Auth::user()->code;
        $eleves_prof = [];
        
        $ressourceEval = $evaluation->ressource; 

        if (! empty($ressourceEval) ) {        
            $ratio = 0;
            foreach($ressourceEval->groupe as $groupe_prof){
                
                if($groupe_prof->pivot->code_prof == $code_user) {
                    $ratio +=1;
                    array_push($eleves_prof, $groupe_prof->eleves);
                }
            }
            foreach($eleves_prof as $eleve_prof){
                foreach($eleve_prof as $eleve_prof){
                    $pivotData = $eleve_prof
                    ->evaluations()
                    ->where('id_evaluation', $idEval)->first();
        
                    if ($pivotData) {
                        $note = $pivotData->pivot->note;
                    } else {
                        $note = '';
                    }
                    
                    $infosEleve = ['nom'=>$eleve_prof->nom, 'identification'=>$eleve_prof->identification, 'prenom'=>$eleve_prof->prenom,'id_groupe'=>$eleve_prof->id_groupe, 'note'=>$note,'code'=>$eleve_prof->code];
                    
                    array_push($eleves, $infosEleve);
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
        $eleve = Eleve::findOrFail($idEleve);


        if ($note >=0 && $note <=20 && $evaluation && $eleve) {
        $evaluation->eleves()->syncWithoutDetaching([
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
