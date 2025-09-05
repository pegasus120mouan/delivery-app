<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\CoutLivraisonController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeliveryServiceController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\pointLivreurController;
use App\Http\Controllers\MontantController;





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
Route::put('/delivery_services/{deliveryService}/update-logo', [DeliveryServiceController::class, 'updateLogo'])->name('delivery_services.update-logo');

Route::get('delivery_services/{id}/associer-gerant', [DeliveryServiceController::class, 'editGerant'])->name('delivery_services.editGerant');
Route::put('delivery_services/{id}/associer-gerant', [DeliveryServiceController::class, 'updateGerant'])->name('delivery_services.updateGerant');
Route::post('delivery_services/{id}/associate-boutique', [DeliveryServiceController::class, 'associateBoutique'])->name('delivery_services.associate_boutique');
Route::post('delivery_services/{id}/associate-driver', [DeliveryServiceController::class, 'associateDriver'])->name('delivery_services.associate_driver');


Route::get('delivery_services/services_actifs', [DeliveryServiceController::class, 'services_actifs'])->name('delivery_services.services_actifs');
Route::get('delivery_services/services_inactifs', [DeliveryServiceController::class, 'services_inactifs'])->name('delivery_services.services_inactifs');
Route::post('delivery_services/{id}/resend-verification', [DeliveryServiceController::class, 'resendVerificationEmail'])->name('delivery_services.resend_verification');
Route::get('delivery_services/search', [DeliveryServiceController::class, 'search'])->name('delivery_services.search');
Route::resource("delivery_services", DeliveryServiceController::class);

// Route pour afficher les commandes par service de livraison
Route::get('/commandes/par-service', [CommandeController::class, 'parService'])
    ->name('commandes.par_service');




Route::get('/livreurs', [UtilisateurController::class, 'livreurs'])->name('utilisateurs.livreurs');
Route::get('/gestionnaires', [UtilisateurController::class, 'gestionnaires'])->name('utilisateurs.gestionnaires');
Route::get('/utilisateurs/{utilisateur}/profile', [UtilisateurController::class, 'profile'])->name('utilisateurs.profile');
Route::post('/utilisateurs/{utilisateur}/change-password', [UtilisateurController::class, 'changePassword'])->name('utilisateurs.change-password');
Route::put('/utilisateurs/{utilisateur}/update-avatar', [UtilisateurController::class, 'updateAvatar'])->name('utilisateurs.update-avatar');
Route::resource("utilisateurs", UtilisateurController::class);



/* Route Boutique */
Route::put('/boutiques/{boutique}/update-logo', [BoutiqueController::class, 'updateLogo'])->name('boutiques.update-logo');
Route::post('/boutiques/{id}/add-delivery-service', [BoutiqueController::class, 'addDeliveryService'])->name('boutiques.addDeliveryService');
Route::get('/boutiques/{boutique}/profile', [BoutiqueController::class, 'profile'])->name('boutiques.profile');

Route::put('/boutiques/{boutique}/associer-client', [BoutiqueController::class, 'updateClient'])->name('boutiques.updateClient');

Route::get('/boutiques/verify', [BoutiqueController::class, 'showVerificationForm'])->name('boutiques.showVerificationForm');
Route::post('/boutiques/verify', [BoutiqueController::class, 'verifyPin'])->name('boutiques.verifyPin');
Route::get('/boutiques_actives', [BoutiqueController::class, 'boutiquesActives'])->name('boutiques.boutiques_actives');
Route::get('/boutiques_inactives', [BoutiqueController::class, 'boutiquesInactives'])->name('boutiques.boutiques_inactives');
Route::post('/boutiques/{boutique}/resend-verification', [BoutiqueController::class, 'resendVerification'])->name('boutiques.resendVerification');

Route::resource('boutiques', BoutiqueController::class);
/* Fin route Boutique */

/* Route cout-livraison */
Route::resource('cout_livraisons', CoutLivraisonController::class);



/******************************Commandes*************************************** */
Route::post('/commandes/attribuer-livreur', [CommandeController::class, 'attribuerLivreur'])
     ->name('commandes.attribuerLivreur');

Route::post('/commandes/change-statut', [CommandeController::class, 'changeStatut'])
     ->name('commandes.changeStatut');

Route::post('/commandes/change-boutique', [CommandeController::class, 'changeBoutique'])
     ->name('commandes.changeBoutique');

Route::get('/commandes/point-du-jour', [CommandeController::class, 'pointDuJour'])
     ->name('commandes.point_du_jour');

Route::get('/commandes/point-hier', [CommandeController::class, 'pointHier'])
     ->name('commandes.point_hier');

//Route::resource('commandes', CommandeController::class);
//Route::resource('commandes', CommandeController::class);
Route::resource('/commandes', CommandeController::class)->middleware('auth');



Route::post('/point/imprimer', [PointController::class, 'imprimer'])->name('point.imprimer')->middleware('auth');




Route::resource('points_livreurs', pointLivreurController::class);

// Route pour les montants
Route::resource('montants', MontantController::class);


