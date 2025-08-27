<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use App\Models\CoutLivraison;
use App\Models\Boutique;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\DB;


class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandes = Commande::orderBy('date_reception', 'DESC')->get();

        $coutLivraisons = CoutLivraison::all();
        $boutiques = Boutique::all();
        $livreurs = Utilisateur::where('role', 'livreur')->get();

        return view('commandes.index', compact('commandes', 'coutLivraisons', 'boutiques', 'livreurs'));
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
        //  $coutLivraison = CoutLivraison::first();
            // Validation des données
                $validated = $request->validate([
            'communes'        => 'required|string|max:255',
            'cout_global'     => 'required|integer|min:0',
            'cout_livraison'  => 'required|integer|min:0',
            'boutique_id'     => 'required|exists:boutiques,id',
          ]);

                // Calcul du coût réel
                $validated['cout_reel'] = $validated['cout_global'] - $validated['cout_livraison'];
                $validated['date_reception'] = now();
                $validated['statut'] = 'Non Livré';

                // Création de la commande
                $commande = Commande::create($validated);

                return redirect()
                    ->route('commandes.index')
                    ->with('success', 'Commande créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Commande $commande)
    {
        return response()->json($commande);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commande $commande)
    {
            // Validation des données
            $request->validate([
                'communes' => 'required|string|max:255',
                'cout_global' => 'required|numeric',
                'cout_livraison' => 'required|numeric',
                'date_reception' => 'nullable|date',
            ]);
        
            // Mise à jour des champs
            $commande->communes = $request->communes;
            $commande->cout_global = $request->cout_global;
            $commande->cout_livraison = $request->cout_livraison;
        
            // Calcul automatique du coût réel
            $commande->cout_reel = $request->cout_global - $request->cout_livraison;
        
            $commande->date_reception = $request->date_reception;
        
            // Sauvegarde
            $commande->save();
        
            return redirect()->route('commandes.index')
                             ->with('success', 'Commande mise à jour avec succès.');
 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
    {
        //
    }

    public function attribuerLivreur(Request $request)
{
    $request->validate([
        'commande_id' => 'required|exists:commandes,id',
        'livreur_id' => 'required|exists:utilisateurs,id'
    ]);

    $commande = Commande::findOrFail($request->commande_id);
    $commande->livreur_id = $request->livreur_id;
    $commande->save();

    return redirect()->route('commandes.index')->with('success', 'Livreur attribué avec succès !');
}

public function changeStatut(Request $request)
{
    $request->validate([
        'commande_id' => 'required|exists:commandes,id',
        'statut' => 'required|in:Livré,Non Livré,Retourné',
    ]);

    $commande = Commande::findOrFail($request->commande_id);
    $commande->statut = $request->statut;

    // Mettre à jour la date selon le statut
    if ($request->statut === 'Livré') {
        $commande->date_livraison = now();
    } elseif ($request->statut === 'Retourné') {
        $commande->date_retour = now();
    }

    $commande->save();

    return redirect()->route('commandes.index')->with('success', 'Statut de livraison modifié avec succès !');
}

    public function changeBoutique(Request $request)
    {
        $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'boutique_id' => 'required|exists:boutiques,id'
        ]);

        $commande = Commande::findOrFail($request->commande_id);
        $commande->boutique_id = $request->boutique_id;
        $commande->save();

        return redirect()->back()->with('success', 'Boutique modifiée avec succès !');
    }

    public function pointDuJour()
{
    $aujourdhui = now()->format('Y-m-d');

    // Totaux globaux
    $montantGlobal = Commande::where('statut', 'Livré')
        ->whereDate('date_livraison', $aujourdhui)
        ->sum('cout_global');

    $montantReel = Commande::where('statut', 'Livré')
        ->whereDate('date_livraison', $aujourdhui)
        ->sum('cout_reel');

    $recetteGlobal = Commande::where('statut', 'Livré')
        ->whereDate('date_livraison', $aujourdhui)
        ->sum('cout_livraison');

    $nombreColisLivres = Commande::where('statut', 'Livré')
        ->whereDate('date_livraison', $aujourdhui)
        ->count();

    // Détail par boutique
    $parBoutique = DB::table('commandes as c')
        ->join('boutiques as b', 'c.boutique_id', '=', 'b.id')
        ->select(
            'c.boutique_id',
            'b.nom_boutique',
            DB::raw("SUM(CASE WHEN c.statut = 'Livré' AND c.date_livraison = CURDATE() THEN c.cout_global ELSE 0 END) AS total_amount"),
            DB::raw("SUM(CASE WHEN c.statut = 'Livré' AND c.date_livraison = CURDATE() THEN c.cout_reel ELSE 0 END) AS total_cout_reel"),
            DB::raw("SUM(CASE WHEN c.statut = 'Livré' AND c.date_livraison = CURDATE() THEN c.cout_livraison ELSE 0 END) AS total_cout_livraison"),
            DB::raw("COUNT(CASE WHEN c.date_livraison = CURDATE() THEN 1 END) AS total_orders"),
            DB::raw("SUM(CASE WHEN c.statut = 'Livré' AND c.date_livraison = CURDATE() THEN 1 ELSE 0 END) AS total_delivered_orders"),
            DB::raw("SUM(CASE WHEN c.date_reception = CURDATE() AND c.date_livraison IS NULL THEN 1 ELSE 0 END) AS total_undelivered_orders")
        )
        ->groupBy('c.boutique_id', 'b.nom_boutique')
        ->havingRaw("SUM(CASE WHEN c.statut = 'Livré' AND c.date_livraison = CURDATE() THEN 1 ELSE 0 END) > 0")
        ->get();

    // Détail par livreur avec cout_livraison et gain_jour
    $parLivreur = DB::table('utilisateurs as u')
        ->join('commandes as c', 'u.id', '=', 'c.livreur_id')
        ->leftJoin('points_livreurs as pl', function($join) use ($aujourdhui) {
            $join->on('u.id', '=', 'pl.utilisateur_id')
                 ->whereDate('pl.date_jour', '=', $aujourdhui);
        })
        ->select(
            DB::raw("CONCAT(u.nom, ' ', u.prenoms) AS livreur"),
            DB::raw("SUM(c.cout_livraison) AS total_cout_livraison"),
            DB::raw("IFNULL(pl.depenses, 0) AS depenses"),
            DB::raw("(SUM(c.cout_livraison) - IFNULL(pl.depenses, 0)) AS gain_jour")
        )
        ->where('c.statut', 'Livré')
        ->whereDate('c.date_livraison', $aujourdhui)
        ->groupBy('u.id', 'livreur', 'pl.depenses')
        ->orderBy('livreur')
        ->get();

    return view('commandes.point_du_jour', compact(
        'montantGlobal',
        'montantReel',
        'recetteGlobal',
        'nombreColisLivres',
        'parBoutique',
        'parLivreur' // <-- livreurs avec cout_livraison et gain_jour
        
    ));
}

    


}
