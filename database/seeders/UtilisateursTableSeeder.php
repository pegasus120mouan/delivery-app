<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UtilisateursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clé étrangère temporairement
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('utilisateurs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Créer des utilisateurs de test
        $utilisateurs = [
            [
                'code' => Str::random(6),
                'nom' => 'Admin',
                'prenoms' => 'Système',
                'contact' => '+2250102030405',
                'whatsapp' => '+2250102030405',
                'lieu_habitation' => 'Abidjan, Plateau',
                'role' => 'admin',
                'email' => 'admin@example.com',
                'login' => 'admin',
                'password' => Hash::make('password'),
                'email_verification_token' => Str::random(60),
                'email_verified' => true,
                'avatar' => 'admin.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => Str::random(6),
                'nom' => 'Dupont',
                'prenoms' => 'Jean',
                'contact' => '+2250506070809',
                'whatsapp' => null,
                'lieu_habitation' => 'Abidjan, Cocody',
                'role' => 'client',
                'email' => 'client@example.com',
                'login' => 'client123',
                'password' => Hash::make('password'),
                'email_verification_token' => Str::random(60),
                'email_verified' => true,
                'avatar' => 'default.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => Str::random(6),
                'nom' => 'Koné',
                'prenoms' => 'Amadou',
                'contact' => '+2250708091011',
                'whatsapp' => '+2250708091011',
                'lieu_habitation' => 'Abidjan, Yopougon',
                'role' => 'livreur',
                'email' => 'livreur@example.com',
                'login' => 'livreur01',
                'password' => Hash::make('password'),
                'email_verification_token' => Str::random(60),
                'email_verified' => false,
                'avatar' => 'livreur.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => Str::random(6),
                'nom' => 'Traoré',
                'prenoms' => 'Aïcha',
                'contact' => '+2250304050607',
                'whatsapp' => null,
                'lieu_habitation' => 'Abidjan, Treichville',
                'role' => 'gerant',
                'email' => 'gerant@example.com',
                'login' => 'gerant_shop',
                'password' => Hash::make('password'),
                'email_verification_token' => Str::random(60),
                'email_verified' => true,
                'avatar' => 'gerant.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insérer les données dans la table
        DB::table('utilisateurs')->insert($utilisateurs);

        // Optionnel: créer des utilisateurs supplémentaires avec une factory
        // \App\Models\Utilisateur::factory(10)->create();
    }
}