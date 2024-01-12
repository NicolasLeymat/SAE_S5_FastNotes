<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ressource;


class RessourceController extends Controller
{
    public function index() {
        $tabRessources = Ressource::paginate(10);
        return view('afficherRessources', compact('tabRessources'));
    }
}