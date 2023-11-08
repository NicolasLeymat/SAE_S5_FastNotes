<?php

namespace App\Http\Controllers;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Graph\PieGraph;
use Amenadiel\JpGraph\Plot\BoxPlot;
use Amenadiel\JpGraph\Plot\PiePlot;
use Amenadiel\JpGraph\Plot\StockPlot;
use App\Imports\EvaluationImport;
use App\Models\Evaluation;
use App\Models\Utilisateur;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Runner\GarbageCollection\GarbageCollectionHandler;

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

    public function boxPlot($idEval){
        $notes = [6, 47, 49, 15, 43, 40, 39, 45, 41, 36];//recuperer les notes d'une eval sous forme de liste
        sort($notes);
        $len = count($notes);
        if ($len%2 == 1) {
            $rangMediane = ($len+1)/2;
            $rangPQuartile = ($rangMediane)/2;
            $rangTQuartile = $rangMediane+($rangMediane)/2;
            $mediane = $notes[$rangMediane-1];
            $pQuartile = $notes[$rangPQuartile-1];
            $tQuartile = $notes[$rangTQuartile-1];
        } else {
            $rangMediane = $len/2;
            $rangPQuartile = $rangMediane/2;
            $rangTQuartile = $rangMediane+($rangMediane/2);
            $mediane = ($notes[$rangMediane-1]+$notes[$rangMediane])/2;
            $pQuartile = $notes[floor($rangPQuartile)];
            $tQuartile = $notes[$rangTQuartile];
        }
        $stats = [$pQuartile, $tQuartile, $notes[0], end($notes), $mediane];

        $graphique = new Graph(300,200);
        $graphique->SetScale("textlin");
        $graphique->SetMarginColor('lightblue');
        $graphique->title->Set('Stockchart example');

        $p1   = new BoxPlot($stats);
        $p1->SetColor('black');
        $p1->SetWidth(9);

        $graphique->Add($p1);
        if(file_exists(public_path().'\images\graph'.$idEval.'.jpg')) {
            unlink(public_path().'\images\graph'.$idEval.'.jpg');
        }
        $graph = $graphique->Stroke(public_path().'\images\graph'.$idEval.'.jpg');
        
        

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
