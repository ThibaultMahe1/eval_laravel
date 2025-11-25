<?php

use App\Http\Controllers\EquipeController;
use App\Http\Controllers\JoueurController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RencontreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('language/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'fr'])) {
        if (auth()->check()) {
            auth()->user()->update(['language' => $lang]);
        }
        session(['locale' => $lang]);
    }

    return back();
})->name('language.switch');

Route::get('/dashboard', [RencontreController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('equipes', EquipeController::class);
    Route::resource('joueurs', JoueurController::class);
    Route::resource('rencontres', RencontreController::class);
});

require __DIR__.'/auth.php';
