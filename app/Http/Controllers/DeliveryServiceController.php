<?php

namespace App\Http\Controllers;

use App\Models\DeliveryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notifiable; // Ajouter cette ligne
use Illuminate\Support\Facades\Storage;
use App\Models\Utilisateur;




class DeliveryServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // $delivery_services = DeliveryService::all();
      //  return view('delivery_services.index', compact('delivery_services'));

        $delivery_services = DeliveryService::with('utilisateurs')->get();
        return view('delivery_services.index', compact('delivery_services'));
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:delivery_services,email',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
        ]);
        
        // Générer un token de vérification (64 caractères pour plus de sécurité)
        $validated['email_verification_token'] = \Illuminate\Support\Str::random(64);
        $validated['email_verified'] = false;
        
        $deliveryService = DeliveryService::create($validated);
        
        \Log::info('Token généré: ' . $validated['email_verification_token']);
        \Log::info('Service créé: ' . $deliveryService->id);
        
        // Envoyer l'email de vérification
        $deliveryService->notify(new \App\Notifications\VerifyDeliveryServiceEmail($deliveryService));
        
        return redirect()->route('delivery_services.index')
            ->with('success', 'Service de livraison créé avec succès. Un email de vérification a été envoyé.');
    }

// App\Http\Controllers\DeliveryServiceController.php
public function verifyEmail($token)
{
    try {
        \Log::info('Token reçu: ' . $token);
        
        // Chercher le service de livraison avec le token
        $deliveryService = DeliveryService::where('email_verification_token', $token)->first();

        if (!$deliveryService) {
            \Log::error('Token non trouvé: ' . $token);
            return redirect()->route('delivery_services.index')
                ->with('error', 'Token de vérification invalide ou expiré.');
        }

        \Log::info('Service trouvé: ' . $deliveryService->nom);

        if ($deliveryService->email_verified) {
            return redirect()->route('delivery_services.index')
                ->with('info', 'Email déjà vérifié.');
        }

        // Mettre à jour le service de livraison
        $deliveryService->email_verified = true;
        $deliveryService->email_verification_token = null;
        $deliveryService->save();

        \Log::info('Email vérifié avec succès pour: ' . $deliveryService->email);

        return redirect()->route('delivery_services.index')
            ->with('success', 'Email vérifié avec succès ! Le service de livraison ' . $deliveryService->nom . ' est maintenant actif.');

    } catch (\Exception $e) {
        \Log::error('Erreur lors de la vérification d\'email: ' . $e->getMessage());
        
        return redirect()->route('delivery_services.index')
            ->with('error', 'Une erreur s\'est produite lors de la vérification.');
    }
}

    /**
     * Display the specified resource.
     */
    public function show(DeliveryService $deliveryService)
    {
        return response()->json($deliveryService);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryService $deliveryService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeliveryService $deliveryService)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
        ]);

        $deliveryService->update($validated);
        return redirect()->route('delivery_services.profile', $deliveryService->id)
                     ->with('popup', true);
    }

    public function updateLogo(Request $request, DeliveryService $deliveryService)
    {
        $request->validate([
            'logo' => 'required|image|max:2048', // Vérifie que c'est une image, max 2 Mo
        ]);
    
        // Supprimer l'ancien logo s'il existe
        if ($deliveryService->logo) {
            Storage::disk('public')->delete('delivery_services/' . $deliveryService->logo);
        }
    
        // Stocker la nouvelle image
        $logoName = time() . '.' . $request->logo->extension();
        $request->logo->storeAs('delivery_services', $logoName, 'public');
    
        // Mettre à jour le champ avatar dans la base de données
        $deliveryService->update(['logo' => $logoName]);
    
        return redirect()->back()->with('success', 'Logo mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryService $deliveryService)
    {
        $deliveryService->delete();
        return redirect()->route('delivery_services.index')
                     ->with('success', 'Service de livraison supprimé avec succès.');
    }

                public function profile($id)
            {
                $deliveryService = DeliveryService::with('utilisateurs')->findOrFail($id);

                // On récupère uniquement les utilisateurs qui ont le rôle "gerant"
                $gerants = Utilisateur::where('role', 'gerant')->get();

                return view('delivery_services.profile', compact('deliveryService', 'gerants'));
            }

    public function editGerant($id)
{
    $delivery_service = DeliveryService::findOrFail($id);

    // Récupérer seulement les utilisateurs avec role = 'gerant'
    $gerants = Utilisateur::where('role', 'gerant')->get();

    return view('delivery_services.associer_gerant', compact('delivery_service', 'gerants'));
}


public function updateGerant(Request $request, $id)
{
    $delivery_service = DeliveryService::findOrFail($id);

    // Associer l’utilisateur choisi au service
    $delivery_service->utilisateurs()->syncWithoutDetaching([$request->gerant_id]);

  //  return redirect()->route('delivery_services.index')
                   //  ->with('success', 'Gérant associé avec succès au service.');

                     return redirect()->route('delivery_services.profile', $delivery_service)
            ->with('success', 'Gérant associé avec succès au service.');
}


}
