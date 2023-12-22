<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UE;

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
}
