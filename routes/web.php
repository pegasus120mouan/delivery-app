<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeliveryServiceController;




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
    return view('auth.login');
});


Route::get('/verify-email/{token}', [DeliveryServiceController::class, 'verifyEmail'])
    ->name('delivery-service.verify-email');
Route::get('/delivery_services/{deliveryService}/profile', [DeliveryServiceController::class, 'profile'])->name('delivery_services.profile');
Route::resource("delivery_services", DeliveryServiceController::class);




Route::get('/livreurs', [UtilisateurController::class, 'livreurs'])->name('utilisateurs.livreurs');
Route::get('/gestionnaires', [UtilisateurController::class, 'gestionnaires'])->name('utilisateurs.gestionnaires');
Route::get('/utilisateurs/{utilisateur}/profile', [UtilisateurController::class, 'profile'])->name('utilisateurs.profile');
Route::post('/utilisateurs/{utilisateur}/change-password', [UtilisateurController::class, 'changePassword'])->name('utilisateurs.change-password');
Route::put('/utilisateurs/{utilisateur}/update-avatar', [UtilisateurController::class, 'updateAvatar'])->name('utilisateurs.update-avatar');
Route::resource("utilisateurs", UtilisateurController::class);
