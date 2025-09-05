<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class CommandesTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 100; $i++) {
            $dateReception = $faker->dateTimeBetween('-10 days', 'now');
            $dateLivraison = $faker->boolean(70) ? Carbon::instance($faker->dateTimeBetween($dateReception, 'now')) : null;
            $dateRetour = ($dateLivraison && $faker->boolean(20)) ? Carbon::instance($faker->dateTimeBetween($dateLivraison, 'now')) : null;

            $coutLivraison = $faker->numberBetween(1000, 5000);
            $coutReel = $faker->numberBetween(5000, 30000);
            $coutGlobal = $coutReel + $coutLivraison;

            DB::table('commandes')->insert([
                'communes'       => $faker->randomElement(['Abobo', 'Cocody', 'Yopougon', 'Treichville', 'Marcory']),
                'cout_global'    => $coutGlobal,
                'cout_livraison' => $coutLivraison,
                'cout_reel'      => $coutReel,
                'statut' => $faker->randomElement(['Livré', 'Non Livré', 'Retourné']),
                'date_reception' => $dateReception,
                'date_livraison' => $dateLivraison,
                'date_retour'    => $dateRetour,
                'boutique_id'    => 1,   // adapte si tu as plusieurs boutiques
                'livreur_id'     => null, // tu pourras tester avec des livreurs plus tard
                'code'  => 'CMD-' . date('ymd') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                
            ]);
        }
    }
}
