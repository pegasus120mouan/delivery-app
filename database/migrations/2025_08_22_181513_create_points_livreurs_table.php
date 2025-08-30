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
        Schema::create('points_livreurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('utilisateur_id'); // clé étrangère vers utilisateurs.id
            $table->integer('recettes')->default(0);
            $table->integer('depenses')->nullable();
            $table->integer('gain_jour')->virtualAs('recettes - IFNULL(depenses,0)'); // calculé automatiquement
            $table->date('date_jour')->default(now());
    
            // Définition de la clé étrangère
            $table->foreign('utilisateur_id')
                  ->references('id')
                  ->on('utilisateurs')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_livreurs');
    }
};
