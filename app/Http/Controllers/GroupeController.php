<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupe;
use App\Models\Parcours;

class GroupeController extends Controller
{
    public function index() {
        $tabGroupes = Groupe::paginate(10);
        
        return view('affichage_elements.afficherGroupes', compact('tabGroupes'));
    }

    public function create() {
        $listeParcours = Parcours::all();

        return view ('ajoutGroupe',compact('listeParcours'));
    }
}