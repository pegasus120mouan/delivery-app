<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoutLivraisonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cout_livraisons')->insert([
            ['cout_livraison' => 1000, 'created_at' => now(), 'updated_at' => now()],
            ['cout_livraison' => 1500, 'created_at' => now(), 'updated_at' => now()],
            ['cout_livraison' => 2000, 'created_at' => now(), 'updated_at' => now()],
            ['cout_livraison' => 2500, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
