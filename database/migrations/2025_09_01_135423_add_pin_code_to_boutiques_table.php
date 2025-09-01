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
        Schema::table('boutiques', function (Blueprint $table) {
            if (!Schema::hasColumn('boutiques', 'pin_code')) {
                $table->string('pin_code')->nullable()->after('email');
            }
            if (!Schema::hasColumn('boutiques', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('pin_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $table->dropColumn(['pin_code', 'email_verified_at']);
        });
    }
};
