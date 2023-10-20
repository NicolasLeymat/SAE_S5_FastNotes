<?php

use App\Http\Controllers\EleveController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashprof', function () {
    return view('dashprof');
})->name('dashprof');

Route::get('/evaluation', function () {
    return view('evaluation');
})->name('evaluation');

Route::get('/visuNote', function () {
    return view('visuNote');
})->name('visuNote');

Route::post('saisir_note',[EvaluationController::class, 'saisirNote'])->name('saisir_note');
Route::post('saisir_notes',[EvaluationController::class, 'saisirNotes'])->name('saisir_notes');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('evaluation', EvaluationController::class);
Route::resource('evaluation', EvaluationController::class)->name("index","evaluations");

Route::resource('visualisation', EleveController::class);
