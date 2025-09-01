<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\BoutiqueVerificationMail;

class BoutiqueController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boutiques = Boutique::with('clients')->get();
        return view('boutiques.index', compact('boutiques'));

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
            'nom_boutique' => 'required|string|max:255',
            'adresse' => 'required|string',
            'commune' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255|unique:boutiques,email',

        ]);

        // Set default status and generate PIN
        $validated['statut'] = 'Inactive';
        $validated['pin_code'] = mt_rand(100000, 999999); // Generate a 6-digit PIN
        
        // Generate unique boutique code
        $yearSuffix = substr(date('Y'), -2); // Get last 2 digits of year
        $randomCode = strtoupper(substr(uniqid(), -8)); // Generate 8 character random code
        $validated['code'] = "BO{$yearSuffix}-{$randomCode}";

        try {
            $boutique = Boutique::create($validated);

            // Send verification email if an email is provided
            if ($boutique->email) {
                Mail::to($boutique->email)->send(new BoutiqueVerificationMail($boutique));
            }

            return redirect()->route('boutiques.index')
                ->with('success', 'Boutique créée avec succès ! Un e-mail de vérification a été envoyé si une adresse e-mail a été fournie.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création de la boutique : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Boutique $boutique)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Boutique $boutique)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Boutique $boutique)
    {
        $validated = $request->validate([
            'nom_boutique' => 'required|string|max:255',
            'adresse' => 'required|string',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);
        $boutique->update($validated);
        return redirect()->route('boutiques.profile', $boutique->id)
                     ->with('popup', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Boutique $boutique)
    {
        $boutique->delete();
        return redirect()->route('boutiques.index')
                     ->with('success', 'Boutique supprimée avec succès.');
    }

    public function profile($id)
    {
        $boutique = Boutique::with([
            'clients',
            'deliveryServices.utilisateurs' => function($query) {
                $query->select('utilisateurs.id', 'nom', 'prenoms', 'contact', 'email');
            }
        ])->findOrFail($id);

        $clients = Utilisateur::where('role', 'client')->get();
        $deliveryServices = \App\Models\DeliveryService::with('utilisateurs')->get();

        return view('boutiques.profile', compact('boutique', 'clients', 'deliveryServices'));
    } 

            public function updateClient(Request $request, $id)
        {
            $boutique = Boutique::findOrFail($id);

            // Associer l’utilisateur choisi au service
            $boutique->clients()->syncWithoutDetaching([$request->client_id]);

        //  return redirect()->route('delivery_services.index')
                        //  ->with('success', 'Gérant associé avec succès au service.');

                            return redirect()->route('boutiques.profile', $boutique)
                    ->with('success', 'Client associé avec succès à la boutique.');
        }

        public function updateLogo(Request $request, Boutique $boutique)
        {
            $request->validate([
                'logo' => 'required|image|max:2048', // Vérifie que c'est une image, max 2 Mo
            ]);
        
            // Supprimer l'ancien logo s'il existe
            if ($boutique->logo) {
                Storage::disk('public')->delete('boutiques/' . $boutique->logo);
            }
        
            // Stocker la nouvelle image
            $logoName = time() . '.' . $request->logo->extension();
            $request->logo->storeAs('boutiques', $logoName, 'public');
        
            // Mettre à jour le champ logo dans la base de données
            $boutique->update(['logo' => $logoName]);
        
            return redirect()->route('boutiques.profile', $boutique)
                    ->with('popup', true)
                    ->with('success', 'Logo mis à jour avec succès.');
        }

    public function addDeliveryService(Request $request, $id)
    {
        $boutique = Boutique::findOrFail($id);
        $deliveryServices = $request->input('delivery_services', []);

        $boutique->deliveryServices()->syncWithoutDetaching($deliveryServices);

        return redirect()->route('boutiques.profile', $boutique->id)
                         ->with('success', 'Services de livraison associés avec succès.');
    }

    public function showVerificationForm()
    {
        return view('boutiques.verify');
    }

    public function verifyPin(Request $request)
    {
        $request->validate([
            'pin_code' => 'required|string',
        ]);

        $boutique = Boutique::where('pin_code', $request->pin_code)->first();

        if (!$boutique) {
            return redirect()->back()->with('error', 'Code PIN invalide ou expiré.');
        }

        $boutique->email_verified_at = now();
        $boutique->statut = 'Active';
        $boutique->pin_code = null; // Clear the PIN after verification
        $boutique->save();

        return redirect()->route('boutiques.index')->with('success', 'Votre boutique a été vérifiée avec succès et activée.');
    }

    public function boutiquesActives()
    {
        $boutiques = Boutique::whereNotNull('email_verified_at')->with('clients')->get();
        return view('boutiques.boutiques_actives', compact('boutiques'));
    }

    public function boutiquesInactives()
    {
        $boutiques = Boutique::whereNull('email_verified_at')->with('clients')->get();
        return view('boutiques.boutiques_inactives', compact('boutiques'));
    }

    public function resendVerification(Boutique $boutique)
    {
        // Check if boutique has an email
        if (!$boutique->email) {
            return redirect()->back()->with('error', 'Cette boutique n\'a pas d\'adresse e-mail.');
        }

        // Check if boutique is already verified
        if ($boutique->email_verified_at) {
            return redirect()->back()->with('error', 'Cette boutique est déjà vérifiée.');
        }

        // Generate new PIN (regenerate if exists or create if doesn't exist)
        $boutique->pin_code = mt_rand(100000, 999999);
        $boutique->save();

        // Send verification email
        try {
            Mail::to($boutique->email)->send(new BoutiqueVerificationMail($boutique));
            return redirect()->back()->with('success', 'E-mail de vérification renvoyé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'envoi de l\'e-mail : ' . $e->getMessage());
        }
    }
}
