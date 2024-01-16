<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupe;
use DB;

class GroupeController extends Controller
{
    public function index() {
        $tabGroupes = Groupe::paginate(10);
        
        return view('affichage_elements.afficherGroupes', compact('tabGroupes'));
    }

    public function destroy(Request $request) {
        $groupeId = $request->input('groupe');

        $groupe = Groupe::findOrFail($groupeId);

        foreach($groupe->eleves as $eleve){
            $eleve->id_groupe = null;
            $eleve->save();
        }

        $req = DB::table('enseignements')
        ->where('id_groupe',$groupeId)
        ->delete();

        $req = DB::table('ressource_groupe')
        ->where('id_groupe',$groupeId)
        ->delete();

        $groupe->delete();

        return redirect()->back()->with('message', 'Suppression effectuée avec succès.');
    }
}