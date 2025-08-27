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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('communes');
            $table->integer('cout_global');
            $table->integer('cout_livraison');
            $table->integer('cout_reel');
            $table->enum('statut', ['Livré', 'Non Livré', 'Retourné'])->default('Non Livré'); 
            $table->date('date_reception')->nullable();
            $table->date('date_livraison')->nullable();
            $table->date('date_retour')->nullable(); 
            $table->unsignedBigInteger('boutique_id');
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('cascade');
            $table->unsignedBigInteger('livreur_id')->nullable();
            $table->foreign('livreur_id')->references('id')->on('utilisateurs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
