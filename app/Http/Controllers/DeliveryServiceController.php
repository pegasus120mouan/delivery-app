<?php

namespace App\Http\Controllers;

use App\Models\DeliveryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notifiable; // Ajouter cette ligne




class DeliveryServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $delivery_services = DeliveryService::all();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryService $deliveryService)
    {
        //
    }

    public function profile(DeliveryService $deliveryService)
    {
        return view('delivery_services.profile', compact('deliveryService'));
    }


}
