<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professeur;
use App\Models\Groupe;
use App\Models\Parcours;
use App\Models\Semestre;
use App\Models\Utilisateur;
use Illuminate\Validation\Rule;

use DB;
use Illuminate\Support\Facades\Hash;


class ProfController extends Controller
{
    public function index(){
        $tabProf = Professeur::paginate(10);
        $listeUtilisateurs = [];
        foreach ($tabProf as $prof) {
           array_push($listeUtilisateurs,$prof->utilisateur) ;
        }
        return view('affichage_elements.listeProfs', compact('tabProf','listeUtilisateurs'));
    }

    public function store(Request $request) {

        $customErrorMessages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
            'regex' => 'Le champ :attribute doit contenir au moins une majuscule et un chiffre.',
            'same' => 'Les mots de passe doivent être identiques',
            'unique' => 'Ce code est déja utilisé'
        ];
        

        $validator =  $request ->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'password' => ['required','string','min:8','regex:/[A-Z]/','regex:/[0-9]/'],
            'code' => 'required|string|max:255|unique:users',
            'confirm_password'=>'required|same:password',
            'email'=>'required|string|max:255'],$customErrorMessages
        );


        $utilisateur = Utilisateur::create(['nom'=>$request->input('nom'),
        'prenom'=>$request->input('prenom'),
        'code'=>$request->input('code'),
        'password'=>Hash::make($request->input('password')),
        'email'=>$request->input('email')]);

        $prof = Professeur::create(['code'=>$request->input('code'), 'isProf'=>true, 'utilisateur'=>$utilisateur]);

        return redirect()->route('profs.index')->withErrors($validator);


    }
    

    public function show(string $idProf) {

        $prof = Professeur::with('enseignements')->findOrFail($idProf);
        $utilisateur = $prof->utilisateur;
        $enseignements = $prof->enseignements;
        $resListe = [];
        foreach ($enseignements as $enseignement) {
            $groupe = Groupe::findOrFail($enseignement->pivot->id_groupe);
            $parcours = Parcours::findOrFail($groupe->parcours);
            $semestre = $parcours->semestre;
            //dd($semestre);
            array_push($resListe,["nomRessource" => $enseignement["nom"],"groupe" => $groupe->libelle,"semestre"=>$semestre["libelle"],"periode"=>$semestre["id_annee"]]);
        }
        return view ('affichage_elements.infoProf',compact('utilisateur','resListe'));

    }

    public function destroy(Request $request) {
        $profId = $request->input('prof');

        $prof = Professeur::findOrFail($profId);

        $req = DB::table('enseignements')
        ->where('code_prof',$prof->code)
        ->delete();

        $prof->delete();

        return redirect()->back()->with('message', 'Suppression effectuée avec succès.');
    }
}
