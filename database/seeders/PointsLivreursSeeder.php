<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PointLivreur;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PointsLivreursSeeder extends Seeder
{
    public function run(): void
    {
        // On récupère tous les utilisateurs de type 'livreur'
        $livreurs = Utilisateur::where('role', 'livreur')->get();

        foreach ($livreurs as $livreur) {
            // Création de plusieurs points pour chaque livreur
            for ($i = 0; $i < 5; $i++) {
                PointLivreur::create([
                    'utilisateur_id' => $livreur->id,
                    'recettes'       => rand(1000, 5000),
                    'depenses'       => rand(100, 1000),
                    'gain_jour'      => rand(500, 4000),
                    'date_jour'      => Carbon::today()->subDays($i), // différentes dates
                ]);
            }
        }
    }
}
