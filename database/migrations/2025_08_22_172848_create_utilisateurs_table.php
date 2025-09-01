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
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('nom');
            $table->string('prenoms');
            $table->string('contact')->unique();
            $table->string('whatsapp')->nullable();            
            $table->string('lieu_habitation')->nullable();
            $table->enum('role', ['admin', 'client', 'livreur','gerant'])->default('admin');
            $table->string('email')->nullable();
            $table->string('login')->unique();
            $table->string('password');
            $table->string('email_verification_token')->nullable();
            $table->boolean('email_verified')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('avatar')->default('default.png');

            $table->foreignId('delivery_service_id')->nullable()->constrained('delivery_services')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
