<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UtilisateursTableSeeder::class,
            DeliveryServiceSeeder::class,
            CoutLivraisonsTableSeeder::class,
            BoutiqueSeeder::class,
            // Ajoutez d'autres seeders ici si nécessaire
        ]);
    }
}