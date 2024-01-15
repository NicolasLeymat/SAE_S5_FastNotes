<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annee;

class AnneeController extends Controller
{
    public function index() {
        $tabAnnees = Annee::paginate(10);
        
        return view('afficherAnnees', compact('tabAnnees'));
    }
}