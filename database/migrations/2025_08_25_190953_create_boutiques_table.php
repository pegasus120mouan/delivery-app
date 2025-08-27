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
    Schema::create('boutiques', function (Blueprint $table) {
        $table->id();
        $table->string('nom_boutique', 255);
        $table->text('adresse');
        $table->string('commune', 255);
        $table->string('telephone', 20);
        $table->string('email', 255)->nullable();
        

        // clé étrangère vers la table utilisateurs (nullable)
        $table->foreignId('responsable_id')
              ->nullable()
              ->constrained('utilisateurs')
              ->nullOnDelete(); // si le responsable est supprimé → valeur NULL

        $table->enum('statut', ['Active', 'Inactive'])->default('Inactive');
        $table->string('logo')->default('shop.png');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boutiques');
    }
};
