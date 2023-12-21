<?php

namespace App\Http\Controllers;

use App\Imports\EvaluationImport;
use App\Models\Eleve;
use App\Models\Evaluation;
use App\Mail\Notif;
use App\Models\Professeur;
use Illuminate\Support\Facades\Mail;
use Auth;
use BoxPlot;
use DB;
use Graph;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Gate;

class EvaluationController extends Controller
{
    private $notes = [];
    private $eval;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        $results = DB::table('evaluations')->get()->sortBy('libelle');
        $user = Professeur::find(Auth::user()->code);
        $ressources = $user->ressource->unique();
        $results = [];
        foreach ($ressources as $ressource){
            $evals = DB::table('evaluations')->distinct()->where('code_ressource',$ressource->code)->get();
            foreach($evals as $eval){
                array_push($results, $eval);
            }
        }
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
        $this->initializeInfosEvaluation($idEval);
        $eleves = [];
        $code_user = Auth::user()->code;
        $eleves_prof = [];
        $groupes=[];
        $ressourceEval = $this->eval->ressource; 

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
                    array_push($groupes, $eleve_prof->id_groupe);
                    $pivotData = $eleve_prof
                    ->evaluations()
                    ->where('id_evaluation', $idEval)->first();
                    if ($pivotData) {
                        $note = $pivotData->pivot->note;
                    } else {
                        $note = '';
                    }
                    $infosEleve = ['nom'=>$eleve_prof->utilisateur->nom, 'identification'=>$eleve_prof->identification, 'prenom'=>$eleve_prof->utilisateur->prenom,'id_groupe'=>$eleve_prof->id_groupe, 'note'=>$note,'code'=>$eleve_prof->code];
                    array_push($eleves, $infosEleve);
                }
            }
            $groupe= array_unique($groupes);
        }
        $evaluation = $this->eval;
        return view('evaluation',compact('evaluation','eleves','groupe'));        
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

            $exists =  $evaluation->eleves()->wherePivot('code_eleve', $idEleve)->exists();
            if ($exists) {
                $oldnote =  $evaluation->eleves()->wherePivot('code_eleve', $idEleve)->first()->pivot->note;
            }
            if (!$exists || $oldnote != $note ) {
                $evaluation->eleves()->syncWithoutDetaching([
                $idEleve => ['note' => $note]]);
                $notif = new Notif($evaluation,$eleve->utilisateur);
                Mail::to($eleve->utilisateur->email)->send($notif);
        }
    }
    }

    public function saisirNotes (Request $request) {
        if (!Gate::allows('isProf')){
            abort(403, Gate::allows('Vous n\'êtes pas prof'));
        }
        $evalId =$request->input('evaluation_id');
        $notes = $request->input('notes');
        foreach ($notes as $eleveID => $note) {            
            if ($note["note"] != null) {
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

    public function boxPlot($idEval){
        sort($this->notes);
        $len = count($this->notes);
        if ($len != 0) {
            if ($len%2 == 1) {
                $rangMediane = ($len+1)/2;
                $rangPQuartile = ($rangMediane)/2;
                $rangTQuartile = $rangMediane+($rangMediane)/2;
                $mediane = $this->notes[$rangMediane-1];
                $pQuartile = $this->notes[$rangPQuartile-1];
                $tQuartile = $this->notes[$rangTQuartile-1];
            } else {
                $rangMediane = $len/2;
                $rangPQuartile = $rangMediane/2;
                $rangTQuartile = $rangMediane+($rangMediane/2);
                $mediane = ($this->notes[$rangMediane-1]+$this->notes[$rangMediane])/2;
                $pQuartile = ($this->notes[$rangPQuartile-1]+$this->notes[$rangPQuartile])/2;
                $tQuartile = ($this->notes[$rangTQuartile-1]+$this->notes[$rangTQuartile])/2;
            }
        $stats = array($pQuartile, $tQuartile, $this->notes[0], end($this->notes), $mediane,$pQuartile, $tQuartile, $this->notes[0], end($this->notes), $mediane);
        } else {
            $stats = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        }
        
        require_once(base_path().'\libraries\jpgraph\src\jpgraph.php');
        require_once (base_path().'\libraries\jpgraph\src\jpgraph_stock.php');
        // Setup a simple graph
        $graph = new Graph(250,200);
        $graph->SetScale('textlin',0,20.2);
        $graph->SetMarginColor('lightblue');
        $graph->xaxis->SetColor('white');
        $graph->title->Set('Notes de l\'évaluation');
        // Create a new stock plot
        $p1 = new BoxPlot($stats,array(0.5,0.5));
        // Width of the bars (in pixels)
        $p1->SetWidth(9);
        // Add the plot to the graph and send it back to the browser
        $graph->Add($p1);
        if(file_exists(public_path().'\images\graph'.$idEval.'.jpg')) {
            unlink(public_path().'\images\graph'.$idEval.'.jpg');
        }
        $graph->Stroke(public_path().'\images\graph'.$idEval.'.jpg');

        if($len == 0) {
            return ['moyenne' => 'Non disponible', 'ecart_type' => 'Non disponible'];
        } else {
            return $this->moyenne_ecart_type();
        }
    }

    function moyenne_ecart_type() {
        $moyenne = array_sum($this->notes)/count($this->notes);
        $fVariance = 0.0;
        foreach ($this->notes as $i) {
            $fVariance += pow($i - $moyenne, 2);
        }     
        $size = count($this->notes) - 1;
        $res = [];
        $res['moyenne'] = $moyenne;
        if ($size == 0){
            $res['ecart_type'] = 0;
        } else {
            $res['ecart_type'] = round((float) sqrt($fVariance)/sqrt($size),3);
        }
        return $res;
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
    public function initializeInfosEvaluation($idEval){
        $this->eval = Evaluation::find($idEval);
        foreach($this->eval->eleves as $eleve) {
            array_push($this->notes, $eleve->pivot->note);            
        }
    }

    public function showStats(string $idEval){
        $this->initializeInfosEvaluation($idEval);
        $evaluation =$this->eval;
        $stats = $this->boxPlot($idEval);
        return view('stats',compact('stats','evaluation'));
    }
}
