<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boutique;
use App\Models\Commande;
use PDF; // alias pour barryvdh/laravel-dompdf

class PointController extends Controller
{
    public function imprimer(Request $request)
    {
        $request->validate([
            'boutique_id' => 'required|exists:boutiques,id',
            'date' => 'required|date',
        ]);

        // Récupérer la boutique
        $boutique = Boutique::findOrFail($request->boutique_id);

        // Récupérer les commandes de cette boutique à la date sélectionnée
        $commandes = Commande::where('boutique_id', $boutique->id)
            ->whereDate('date_reception', $request->date)
            ->get();

        // Générer le PDF
        $pdf = PDF::loadView('points.pdf', compact('boutique', 'commandes', 'request'));

        // Télécharger le PDF
        return $pdf->download('point-'.$boutique->nom_boutique.'-'.$request->date.'.pdf');
    }
}
