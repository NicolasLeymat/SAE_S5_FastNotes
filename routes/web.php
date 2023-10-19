<?php

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
})->name('');

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

Route::get('/dashprof', function () {
    return view('dashprof');
})->middleware(['auth', 'verified'])->name('dashprof');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('evaluations', EvaluationController::class);
Route::resource('evaluations', EvaluationController::class)->name("index","evaluations");