<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semestre;
use App\Models\Parcours;

class ParcoursController extends Controller
{
    public function index() {
        $tabParcours = Parcours::paginate(10);
        $listeSemestres = [];
        foreach ($tabParcours as $parcours) {
            array_push($listeSemestres,$parcours->semestre);
            
        }
        return view('afficherParcours', compact('tabParcours','listeSemestres'));
    }
}