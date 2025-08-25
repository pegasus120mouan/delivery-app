<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery_service_utilisateur', function (Blueprint $table) {
            // Clés étrangères
            $table->foreignId('delivery_service_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->foreignId('utilisateur_id')
                  ->constrained('utilisateurs')
                  ->onDelete('cascade');
            
            // Timestamps
            $table->timestamps();
            
            // Contrainte d'unicité avec un nom PERSONNALISÉ plus court
            $table->unique(
                ['delivery_service_id', 'utilisateur_id'],
                'dsu_service_user_unique' // ← Nom personnalisé court
            );
        }); // ← ICI: Ajouter la parenthèse et le point-virgule manquants
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_service_utilisateur');
    }
};