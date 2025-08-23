<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DeliveryServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deliveryServices = [
            [
                'nom' => 'Livraison Express',
                'email' => 'contact@livraisonexpress.com',
                'telephone' => '+33123456789',
                'logo' => 'express_delivery.png',
                'adresse' => '123 Avenue des Livraisons, Paris',
                'email_verified' => true,
                'email_verification_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Rapid Delivery',
                'email' => 'info@rapiddelivery.fr',
                'telephone' => '+33987654321',
                'logo' => 'rapid_delivery.png',
                'adresse' => '456 Rue de la Vitesse, Lyon',
                'email_verified' => true,
                'email_verification_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Eco Livraison',
                'email' => 'eco@livraison-verte.fr',
                'telephone' => '+33445566778',
                'logo' => 'default.png', // Utilise la valeur par défaut
                'adresse' => '789 Boulevard Écologique, Marseille',
                'email_verified' => false,
                'email_verification_token' => Str::random(60),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'City Delivery',
                'email' => 'service@citydelivery.com',
                'telephone' => null, // Téléphone nullable
                'logo' => 'city_delivery.png',
                'adresse' => null, // Adresse nullable
                'email_verified' => true,
                'email_verification_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insertion des données
        DB::table('delivery_services')->insert($deliveryServices);

        $this->command->info('Services de livraison créés avec succès!');
    }
}