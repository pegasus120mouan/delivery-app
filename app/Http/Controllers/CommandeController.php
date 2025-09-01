<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use App\Models\CoutLivraison;
use App\Models\Boutique;
use App\Models\Utilisateur;
use App\Models\PointsLivreurs;
use App\Models\DeliveryService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with(['deliveryService', 'boutique', 'livreur'])
            ->orderBy('date_reception', 'DESC')
            ->get();
        
        $services = DeliveryService::all();
        $coutLivraisons = CoutLivraison::all();
        $boutiques = Boutique::all();
        $livreurs = Utilisateur::where('role', 'livreur')->get();

        return view('commandes.index', compact('commandes', 'services', 'coutLivraisons', 'boutiques', 'livreurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'communes'        => 'required|string|max:255',
            'cout_global'     => 'required|integer|min:0',
            'cout_livraison'  => 'required|integer|min:0',
            'boutique_id'     => 'required|exists:boutiques,id',
            'delivery_service_id' => 'required|exists:delivery_services,id',
        ]);

        $validated['cout_reel'] = $validated['cout_global'] - $validated['cout_livraison'];
        $validated['date_reception'] = now();
        $validated['statut'] = 'Non Livré';

        Commande::create($validated);

        return redirect()->route('commandes.index')
            ->with('success', 'Commande créée avec succès !');
    }

    public function show(Commande $commande)
    {
        return response()->json($commande);
    }

    public function update(Request $request, Commande $commande)
    {
        $request->validate([
            'communes' => 'required|string|max:255',
            'cout_global' => 'required|numeric',
            'cout_livraison' => 'required|numeric',
            'date_reception' => 'nullable|date',
            'delivery_service_id' => 'required|exists:delivery_services,id',
        ]);

        $commande->communes = $request->communes;
        $commande->cout_global = $request->cout_global;
        $commande->cout_livraison = $request->cout_livraison;
        $commande->cout_reel = $request->cout_global - $request->cout_livraison;
        $commande->date_reception = $request->date_reception;
        $commande->delivery_service_id = $request->delivery_service_id;
        $commande->save();

        return redirect()->route('commandes.index')
            ->with('success', 'Commande mise à jour avec succès.');
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
    
        if ($request->statut === 'Livré') {
            $commande->date_livraison = now();
            $commande->date_retour = null; // au cas où elle avait été retournée avant
        } elseif ($request->statut === 'Non Livré') {
            $commande->date_livraison = null;
            $commande->date_retour = null;
        } elseif ($request->statut === 'Retourné') {
            $commande->date_livraison = null;
            $commande->date_retour = now();
        }
    
        $commande->save();
    
        return redirect()->route('commandes.index')->with('success', 'Statut modifié avec succès !');
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

    /**
     * Point du jour (aujourd'hui)
     */
    public function pointDuJour()
    {
        $aujourdhui = Carbon::today()->format('Y-m-d');

        return $this->genererPoint($aujourdhui, 'commandes.point_du_jour');
    }

    /**
     * Point d’hier
     */
    public function pointHier()
    {
        $hier = Carbon::yesterday()->format('Y-m-d');

        return $this->genererPoint($hier, 'commandes.point_hier');
    }

    /**
     * Méthode commune pour générer les stats (évite la duplication du code)
     */
    private function genererPoint($date, $vue)
    {
        $montantGlobal = Commande::where('statut', 'Livré')
            ->whereDate('date_livraison', $date)
            ->sum('cout_global');

        $montantReel = Commande::where('statut', 'Livré')
            ->whereDate('date_livraison', $date)
            ->sum('cout_reel');

        $recetteGlobal = Commande::where('statut', 'Livré')
            ->whereDate('date_livraison', $date)
            ->sum('cout_livraison');

        $nombreColisLivres = Commande::where('statut', 'Livré')
            ->whereDate('date_livraison', $date)
            ->count();

        // Détail par boutique
        $parBoutique = DB::table('commandes as c')
            ->join('boutiques as b', 'c.boutique_id', '=', 'b.id')
            ->leftJoin('delivery_services as ds', 'c.delivery_service_id', '=', 'ds.id')
            ->select(
                'c.boutique_id',
                'c.delivery_service_id',
                'b.nom_boutique',
                'ds.nom as service_livraison',
                DB::raw("SUM(CASE WHEN c.statut = 'Livré' AND DATE(c.date_livraison) = '$date' THEN c.cout_global ELSE 0 END) AS total_amount"),
                DB::raw("SUM(CASE WHEN c.statut = 'Livré' AND DATE(c.date_livraison) = '$date' THEN c.cout_reel ELSE 0 END) AS total_cout_reel"),
                DB::raw("SUM(CASE WHEN c.statut = 'Livré' AND DATE(c.date_livraison) = '$date' THEN c.cout_livraison ELSE 0 END) AS total_cout_livraison"),
                DB::raw("COUNT(CASE WHEN DATE(c.date_livraison) = '$date' THEN 1 END) AS total_orders"),
                DB::raw("SUM(CASE WHEN c.statut = 'Livré' AND DATE(c.date_livraison) = '$date' THEN 1 ELSE 0 END) AS total_delivered_orders"),
                DB::raw("SUM(CASE WHEN DATE(c.date_reception) = '$date' AND c.date_livraison IS NULL THEN 1 ELSE 0 END) AS total_undelivered_orders")
            )
            ->groupBy('c.boutique_id', 'c.delivery_service_id', 'b.nom_boutique', 'ds.nom')
            ->havingRaw("SUM(CASE WHEN c.statut = 'Livré' AND DATE(c.date_livraison) = '$date' THEN 1 ELSE 0 END) > 0")
            ->get();

        // Détail par livreur
        $parLivreur = DB::table('utilisateurs as u')
            ->join('commandes as c', 'u.id', '=', 'c.livreur_id')
            ->leftJoin('points_livreurs as pl', function($join) use ($date) {
                $join->on('u.id', '=', 'pl.utilisateur_id')
                    ->whereDate('pl.date_jour', '=', $date);
            })
            ->select(
                'u.id as livreur_id',
                DB::raw("CONCAT(u.nom, ' ', u.prenoms) AS livreur"),
                DB::raw("SUM(c.cout_livraison) AS total_cout_livraison"),
                DB::raw("MAX(IFNULL(pl.depenses, 0)) AS depenses"),
                DB::raw("(SUM(c.cout_livraison) - MAX(IFNULL(pl.depenses, 0))) AS gain_jour"),
                DB::raw("COUNT(c.id) AS nombre_colis")
            )
            ->where('c.statut', 'Livré')
            ->whereDate('c.date_livraison', $date)
            ->groupBy('u.id', 'livreur')
            ->orderBy('livreur')
            ->get();

        return view($vue, compact(
            'montantGlobal',
            'montantReel',
            'recetteGlobal',
            'nombreColisLivres',
            'parBoutique',
            'parLivreur',
            'date'
        ));
    }

    public function parService(Request $request)
    {
        $serviceId = $request->query('serviceId');
        
        // Récupérer le service de livraison
        $service = \App\Models\DeliveryService::findOrFail($serviceId);
        
        // Construire la requête avec les relations et le tri
        $commandes = Commande::with(['boutique', 'livreur'])
            ->where('delivery_service_id', $serviceId)
            ->orderBy('date_reception', 'DESC')
            ->paginate(25); // 25 éléments par page
            
        // Ajouter les paramètres de tri à la pagination
        $commandes->appends(['serviceId' => $serviceId]);
    
        return view('commandes.par_service', [
            'commandes' => $commandes,
            'service' => $service
        ]);
    }
}
