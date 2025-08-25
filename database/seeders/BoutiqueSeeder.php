<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoutiqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('boutiques')->insert([
            [
                'nom_boutique' => 'Fashion Store',
                'adresse' => 'Cocody Angré, Abidjan',
                'commune' => 'Cocody',
                'telephone' => '0700000000',
                'email' => 'contact@fashionstore.ci',
                'responsable' => 'Mme Kouadio',
                'statut' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_boutique' => 'TechZone',
                'adresse' => 'Yopougon Niangon',
                'commune' => 'Yopougon',
                'telephone' => '0755555555',
                'email' => 'support@techzone.ci',
                'responsable' => 'M. Koné',
                'statut' => 'Inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_boutique' => 'Maison Délices',
                'adresse' => 'Marcory Zone 4',
                'commune' => 'Marcory',
                'telephone' => '0788888888',
                'email' => 'contact@maisondelices.ci',
                'responsable' => 'Mme Traoré',
                'statut' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
