<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UE;
use App\Models\Semestre;
use App\Models\Competence;

class UEController extends Controller
{
    public function index(){
        $tabUE = UE::paginate(10);
        $listeCompetences = [];
        $listeSemestres = [];
        foreach ($tabUE as $UE) {
            array_push($listeCompetences,$UE->competence) ;
            array_push($listeSemestres,$UE->semestre);
        }
        
        return view('listeUE', compact('tabUE','listeCompetences','listeSemestres'));
    }

    public function create() {
        $listeSemestres = Semestre::all();
        $listeCompetences = Competence::all();

        return view('ajoutUE',compact('listeSemestres','listeCompetences'));
    }

    public function store(Request $request) {
        
        $validator =  $request ->validate([
            'code' => 'required|string|max:255|unique:ue',
            'libelle' => 'required|string|max:255',
            'competence'=>'required|string|max:255',
            'semestre'=>'required|string|max:255']
        );

        $competence = Competence::findOrFail($request->input('competence'));
        

        $semestre = Semestre::findOrFail($request->input("semestre"));


        $ue = UE::create(['libelle'=>$request->input('libelle'),
        'code'=>$request->input('code'),
        'code_competence'=>$competence->code,
        'id_semestre'=>$semestre->id_semestre]);

        return redirect()->route('ue.index')->withErrors($validator);
    }
}
