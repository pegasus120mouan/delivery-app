<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\AuthController;



// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route protégée pour utilisateurs.index
Route::middleware('auth')->group(function () {
    Route::get('/utilisateurs', [UtilisateurController::class, 'index'])->name('utilisateurs.index');
});

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});



Route::get('/utilisateurs/{id}/profile', [UtilisateurController::class, 'profile'])
         ->name('utilisateurs.profile');
Route::resource("utilisateurs", UtilisateurController::class);
