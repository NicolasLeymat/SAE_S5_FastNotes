<?php

use App\Http\Controllers\EleveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SemestreController;
use App\Http\Controllers\UtilisateurController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\NotifController;
use App\Http\Controllers\ProfController;
use App\Http\Controllers\UEController;
use App\Models\Utilisateur;
use App\Http\Controllers\ParcoursController;
use App\Http\Controllers\RessourceController;
use App\Http\Controllers\EnseignementController;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\AnneeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('index');

Route::middleware('professeur')->group(function () {
    Route::get('/dashprof', function () {
        return view('dashprof');
    })->name('dashprof');
});

Route::get('/dashadmin', function () {
    return view('dashboards.dashAdmin');
})->name('dashadmin');

Route::get('/ajoutEleve', function () {
    return view('ajoutEleves');
})->name('ajoutEleve');

Route::get('/ajoutEval', function () {
    return view('ajoutEvals');
})->name('ajoutEval');

Route::get('/evaluation', function () {
    return view('evaluation');
})->name('evaluation');

Route::get('/visuNote', function () {
    return view('visuNote');
})->name('visuNote');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('professeur')->group(function () {
    Route::resource('evaluation', EvaluationController::class);
    Route::resource('evaluation', EvaluationController::class)->name("index","evaluations");


    Route::get('/dashprof', function () {
        return view('dashprof');
    })->name('dashprof');

    Route::get('/evaluation/{id}/stats', [EvaluationController::class, 'showStats'])->name('evaluation.stats');

    Route::post('saisir_note',[EvaluationController::class, 'saisirNote'])->name('saisir_note');
    Route::post('saisir_notes',[EvaluationController::class, 'saisirNotes'])->name('saisir_notes');
});
Route::post('importEval', [EvaluationController::class, 'import'])->name("importEval");
Route::post('importEvals', [EvaluationController::class, 'import'])->name("importEvals");
Route::post('importEleves', [EleveController::class, 'addManyStudents'])->name("importEleves");
Route::post('importEleve', [EleveController::class, 'addOneStudent'])->name("importEleve");
Route::get('pdf/{id}', [EleveController::class, 'exportBulletinPDF'])->name('pdf');
Route::middleware('eleve')->group(function () {
    Route::resource('visualisation', EleveController::class);
});

Route::middleware('administrateur')->group(function () {
    Route::get('/dashadmin', function () {
        return view('dashboards.dashAdmin');
    })->name('dashadmin');
    Route::resource('profs', ProfController::class);
    Route::resource('ue', UEController::class);
    Route::resource('utilisateurs',UtilisateurController::class);
    Route::resource('parcours', ParcoursController::class);
    Route::resource('ressources', RessourceController::class);
    Route::resource('enseignements', EnseignementController::class);
    Route::resource('groupes', GroupeController::class);
    Route::resource('annees', AnneeController::class);
    Route::resource('semestres', SemestreController::class);
    Route::resource('ressource', RessourceController::class);
    Route::get('/afficherEleves', [EleveController::class, 'afficherEleves'])->name('afficherEleves');
    Route::get('/afficherEvals', [EvaluationController::class, 'afficherEvals'])->name('afficherEvals');
    Route::get('/afficherEnseignement', [EnseignementController::class, 'index'])->name('afficherEns');
    Route::get('/afficherGroupes', [GroupeController::class, 'index'])->name('afficherGroupes');
    Route::get('/afficherAnnees', [AnneeController::class, 'index'])->name('afficherAnnees');
    Route::get('/afficherSemestres', [SemestreController::class, 'index'])->name('afficherSemestres');
    Route::get('/afficherParcours', [ParcoursController::class, 'index'])->name('afficherParcours');
    Route::get('/afficherRessource', [RessourceController::class, 'index'])->name('afficherRessources');
    Route::get('/ajoutUtilisateur', [UtilisateurController::class, 'create'])->name('ajoutUtilisateur');
    Route::delete('supprimerProf',[ProfController::class, 'destroy' ])->name('supprimerProf');
    Route::delete('supprimerEnseignement',[EnseignementController::class, 'destroy' ])->name('supprimerEnseignement');
    Route::delete('supprimerEval',[EvaluationController::class, 'destroy' ])->name('supprimerEval');
    Route::delete('supprimerSemestre',[SemestreController::class, 'destroy' ])->name('supprimerSemestre');
    Route::delete('supprimerAnnee',[AnneeController::class, 'destroy' ])->name('supprimerAnnee');
});

Route::get('pdf/{id}', [EleveController::class, 'exportBulletinPDF'])->name('pdf');


Route::get('email', [NotifController::class, 'getRouteMail']);

Route::post('/envoyerNotif', [NotifController::class, 'envoyerEmail'])->name('envoyerNotif');

