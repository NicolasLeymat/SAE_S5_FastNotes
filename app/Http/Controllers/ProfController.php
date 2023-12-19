<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professeur;

class ProfController extends Controller
{
    public function index(){
        $tabProf = Professeur::paginate(10);
        $listeUtilisateurs = [];
        foreach ($tabProf as $prof) {
           array_push($listeUtilisateurs,$prof->utilisateur) ;
        }
        return view('listeProfs', compact('tabProf','listeUtilisateurs'));
    }
}
