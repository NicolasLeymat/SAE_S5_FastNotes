<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enseignement;
use App\Models\Parcours;
use DB;

class EnseignementController extends Controller
{
    public function index() {
        $tabEnseignements = Enseignement::paginate(10);
        
        return view('affichage_elements.afficherEnseignements', compact('tabEnseignements'));
    }

    public function destroy(Request $request) {
        $profId = $request->input('prof');
        $groupeId = $request->input('groupe');
        $ressourceCode = $request->input('ressource');


        $req = DB::table('enseignements')
        ->where('code_prof',$profId)
        ->where('id_groupe', $groupeId)
        ->where('code_ressource', $ressourceCode)
        ->delete();

        return redirect()->back()->with('message', 'Suppression effectuée avec succès.');
    }
}