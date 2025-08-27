<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommandesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('commandes')->insert([
            [
                'communes' => 'Abobo',
                'cout_global' => 15000,
                'cout_livraison' => 2000,
                'cout_reel' => 13000,
                'statut' => 'Livré',
                'date_reception' => Carbon::now()->subDays(3),
                'date_livraison' => Carbon::now()->subDay(),
                'date_retour' => null,
                'boutique_id' => 1,   // doit exister dans boutiques
                'livreur_id' => null,    // doit exister dans utilisateurs
            ],
            [
                'communes' => 'Cocody',
                'cout_global' => 22000,
                'cout_livraison' => 3000,
                'cout_reel' => 19000,
                'statut' => 'Non Livré',
                'date_reception' => Carbon::now()->subDays(2),
                'date_livraison' => null,
                'date_retour' => null,
                'boutique_id' => 1,
                'livreur_id' => null, // pas encore affecté
            ],
            [
                'communes' => 'Yopougon',
                'cout_global' => 12000,
                'cout_livraison' => 1500,
                'cout_reel' => 10500,
                'statut' => 'Retourné',
                'date_reception' => Carbon::now()->subDays(5),
                'date_livraison' => Carbon::now()->subDays(4),
                'date_retour' => Carbon::now()->subDays(2),
                'boutique_id' => 1,
                'livreur_id' => null,
            ],
        ]);
    }
}
