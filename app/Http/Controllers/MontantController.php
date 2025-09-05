<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\DeliveryService;
use App\Models\Boutique;

class MontantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les commandes avec leurs relations
        $commandes = Commande::with(['boutique', 'deliveryService', 'livreur'])
            ->orderBy('date_reception', 'desc')
            ->get();

        // Grouper par service de livraison et par date
        $montantsGroupes = $commandes->groupBy(function ($commande) {
            $date = \Carbon\Carbon::parse($commande->date_reception)->format('Y-m-d');
            return $commande->delivery_service_id . '_' . $date;
        })->map(function ($group) {
            $first = $group->first();
            
            // Grouper les commandes par boutique pour avoir les détails
            $boutiquesDetails = $group->groupBy('boutique_id')->map(function ($boutiqueCmds) {
                $boutique = $boutiqueCmds->first()->boutique;
                return (object) [
                    'boutique' => $boutique,
                    'commandes' => $boutiqueCmds,
                    'total_cout_global' => $boutiqueCmds->sum('cout_global'),
                    'total_cout_livraison' => $boutiqueCmds->sum('cout_livraison'),
                    'total_cout_reel' => $boutiqueCmds->sum('cout_reel'),
                    'nombre_commandes' => $boutiqueCmds->count(),
                    'benefice' => $boutiqueCmds->sum('cout_global') - $boutiqueCmds->sum('cout_livraison')
                ];
            })->values();
            
            return (object) [
                'delivery_service' => $first->deliveryService,
                'date_reception' => $first->date_reception,
                'total_cout_global' => $group->sum('cout_global'),
                'total_cout_livraison' => $group->sum('cout_livraison'),
                'total_cout_reel' => $group->sum('cout_reel'),
                'nombre_commandes' => $group->count(),
                'benefice' => $group->sum('cout_global') - $group->sum('cout_livraison'),
                'livreurs' => $group->pluck('livreur')->unique('id')->filter()->values(),
                'boutiques' => $group->pluck('boutique')->unique('id')->filter()->values(),
                'boutiques_details' => $boutiquesDetails,
                'group_id' => $first->delivery_service_id . '_' . \Carbon\Carbon::parse($first->date_reception)->format('Y-m-d')
            ];
        })->sortByDesc('date_reception');

        // Calculer les statistiques globales
        $totalMontants = $commandes->sum('cout_global');
        $totalLivraisons = $commandes->sum('cout_livraison');
        $nombreCommandes = $commandes->count();

        return view('montants.index', compact('montantsGroupes', 'totalMontants', 'totalLivraisons', 'nombreCommandes'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
