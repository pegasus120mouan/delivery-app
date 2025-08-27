<?php

namespace App\Http\Controllers;

use App\Models\pointLivreur;
use Illuminate\Http\Request;
use App\Models\Utilisateur;

class pointLivreurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pointsLivreurs = PointLivreur::whereHas('utilisateur', function ($query) {
            $query->where('role', 'livreur');
        })->get();
    
        $utilisateurs = Utilisateur::where('role', 'livreur')->get();
    
        return view('points_livreurs.index', compact('pointsLivreurs', 'utilisateurs'));
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
        // Validation des données
        $validated = $request->validate([
            'utilisateur_id'  => 'required|exists:utilisateurs,id',
            'recettes'        => 'required|integer|min:0',
            'depenses'        => 'required|integer|min:0',
          ]);

                // Calcul du coût réel
                $validated['date_jour'] = now();

                // Création du point de livraison
                $pointLivreur = PointLivreur::create($validated);

                return redirect()
                    ->route('points_livreurs.index')    
                    ->with('success', 'Point de livraison créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(pointLivreur $pointLivreur)
    {
        return response()->json($pointLivreur);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pointLivreur $pointLivreur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $point = PointLivreur::findOrFail($id); // ✅ récupère l'enregistrement existant
    
    $point->update([
        'recettes' => $request->recettes,
        'depenses' => $request->depenses,
        'date_jour' => $request->date_jour,
    ]);

    return redirect()->route('points_livreurs.index')->with('success', 'Point mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pointLivreur $pointLivreur)
    {
        //
    }
}
