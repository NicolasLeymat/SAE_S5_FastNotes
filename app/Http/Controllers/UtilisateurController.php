<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupe;
use App\Models\Parcours;
use App\Models\Utilisateur;
use App\Models\Professeur;
use App\Models\Eleve;
use Illuminate\Support\Facades\Hash;


class UtilisateurController extends Controller
{
    public function create(Request $request) {
        $listeGroupes = Groupe::all();
        $tabParcours = [];
        foreach ($listeGroupes as $grp) {
            $parc = Parcours::findOrFail($grp->parcours);
            $tabParcours[$grp->id]=$parc;
        }
        return view('ajouts.ajoutUtilisateur',compact('listeGroupes', 'tabParcours', 'request'));
    }

    public function store(Request $request) {
        $typesUtilisateur = ['professeur','eleve'];

        $customErrorMessages = [
            'required' => 'Le champ :attribute est requis.',
            'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
            'regex' => 'Le champ :attribute doit contenir au moins une majuscule et un chiffre.',
            'same' => 'Les mots de passe doivent être identiques',
            'unique' => 'Ce code est déja utilisé',
            'in'=>'Le champ :attribute doit contenir une des valeurs suivantes :'.implode(',',$typesUtilisateur)
        ];

        $validator =  $request ->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'password' => ['required','string','min:8','regex:/[A-Z]/','regex:/[0-9]/'],
            'code' => 'required|string|max:255|unique:users',
            'confirm_password'=>'required|same:password',
            'email'=>'required|string|max:255',
            'type'=>'in:'.implode(',',$typesUtilisateur),
            'groupe'=>'exclude_if:type,professeur|string|max:255'],$customErrorMessages
        );


        $utilisateur = Utilisateur::create(['nom'=>$request->input('nom'),
        'prenom'=>$request->input('prenom'),
        'code'=>$request->input('code'),
        'password'=>Hash::make($request->input('password')),
        'email'=>$request->input('email')]);

        if ($request->input('type') == 'professeur') {
            $prof = Professeur::create(['code'=>$request->input('code'), 'isProf'=>true, 'utilisateur'=>$utilisateur]);
            return redirect()->route('profs.index')->withErrors($validator);
        }
        else {

            $eleve = Eleve::create(['code'=>$request->input('code'),'id_groupe'=>$request->input('groupe'),'identification'=>$request->input('code')]);
            return redirect()->route('afficherEleves');
        }

    }
}
