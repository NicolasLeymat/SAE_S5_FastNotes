<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enseignement;
use App\Models\Parcours;

class EnseignementController extends Controller
{
    public function index() {
        $tabEnseignements = Enseignement::paginate(10);
        
        return view('affichage_elements.afficherEnseignements', compact('tabEnseignements'));
    }
}