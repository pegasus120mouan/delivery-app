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
        Schema::table('delivery_services', function (Blueprint $table) {
            $table->decimal('capital', 15, 2)->nullable()->after('adresse'); // Capital du service de livraison
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_services', function (Blueprint $table) {
            $table->dropColumn('capital');
        });
    }
};
