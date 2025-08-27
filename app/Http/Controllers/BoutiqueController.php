<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Models\Utilisateur;

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
            'email' => 'nullable|email|max:255',
            'responsable' => 'required|string|max:255',
            // Supprimer les champs created_at et updated_at de la validation
        ]);
    
        // Ajouter le statut par défaut
        $validated['statut'] = 'Inactive';
    
        try {
            Boutique::create($validated);
            return redirect()->route('boutiques.index')
                ->with('success', 'Boutique créée avec succès !');
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
        //
    }

    public function profile($id)
    {
                $boutique = Boutique::with('clients')->findOrFail($id);

                // On récupère uniquement les utilisateurs qui ont le rôle "gerant"
                $clients = Utilisateur::where('role', 'client')->get();

                return view('boutiques.profile', compact('boutique', 'clients'));
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
}
