<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupe;

class GroupeController extends Controller
{
    public function index() {
        $tabGroupes = Groupe::paginate(10);
        
        return view('afficherGroupes', compact('tabGroupes'));
    }
}