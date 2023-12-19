<?php

use App\Http\Controllers\EleveController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvaluationController;

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
    return view('dashAdmin');
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

    Route::post('saisir_note',[EvaluationController::class, 'saisirNote'])->name('saisir_note');
    Route::post('saisir_notes',[EvaluationController::class, 'saisirNotes'])->name('saisir_notes');
});
Route::post('importEval', [EvaluationController::class, 'import'])->name("importEvals");
Route::post('importEleves', [EleveController::class, 'addManyStudents'])->name("importEleves");
Route::post('importEleve', [EleveController::class, 'addOneStudent'])->name("importEleve");

Route::middleware('eleve')->group(function () {
    Route::resource('visualisation', EleveController::class);
});

Route::middleware('administrateur')->group(function () {
    Route::get('/dashadmin', function () {
        return view('dashAdmin');
    })->name('dashadmin');
});

Route::get('/email', 'App\Http\Controllers\MailController@email_send',);

Route::get('/votre-page', [YourController::class, 'index'])->name('votre-page');
Route::post('/afficherEleves', [YourController::class, 'afficherEleves'])->name('afficherEleves');
Route::post('/afficherEvals', [YourController::class, 'afficherEvaluations'])->name('afficherEvals');