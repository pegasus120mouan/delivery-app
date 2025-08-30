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
        Schema::table('commandes', function (Blueprint $table) {
            $table->unsignedBigInteger('delivery_service_id')->nullable()->after('livreur_id');
            $table->foreign('delivery_service_id')
                  ->references('id')
                  ->on('delivery_services')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropForeign(['delivery_service_id']);
            $table->dropColumn('delivery_service_id');
        });
    }
};
