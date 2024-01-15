<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semestre;

class SemestreController extends Controller
{
    public function index(){
        $tabSemestres = Semestre::paginate(10);
        
        return view('affichage_elements.afficherSemestres', compact('tabSemestres'));
    }

    public function create() {
        //...
    }

    public function store(Request $request) {
        //...
    }

    public function destroy(UE $ue) {
        //...
    }
}
