<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BoutiqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('boutiques')->insert([
            [
                'code' => Str::random(6),
                'nom_boutique' => 'Fashion Store',
                'adresse' => 'Cocody Angré, Abidjan',
                'commune' => 'Cocody',
                'telephone' => '0700000000',
                'email' => 'contact@fashionstore.ci',
                'statut' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => Str::random(6),
                'nom_boutique' => 'TechZone',
                'adresse' => 'Yopougon Niangon',
                'commune' => 'Yopougon',
                'telephone' => '0755555555',
                'email' => 'support@techzone.ci',
                'statut' => 'Inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => Str::random(6),
                'nom_boutique' => 'Maison Délices',
                'adresse' => 'Marcory Zone 4',
                'commune' => 'Marcory',
                'telephone' => '0788888888',
                'email' => 'contact@maisondelices.ci',
                'statut' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
