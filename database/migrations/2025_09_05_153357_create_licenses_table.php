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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('state_id')->constrained()->cascadeOnDelete();

            $table->string('license_number')->index();
            $table->string('license_type')->nullable(); // e.g., MD, DO, APRN
            $table->date('issued_date')->nullable();
            $table->date('expiration_date')->nullable();

            $table->string('active_license_link')->nullable();
            $table->string('expired_license_link')->nullable();
            $table->string('dea_number')->nullable();

            $table->text('notes')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->boolean('mal_praxis_required')->default(false);
            $table->json('forms')->nullable();               // URLs/IDs de formularios
            $table->boolean('need_physical_office')->default(false);
            $table->json('insurance')->nullable();           // pólizas JSON
            $table->string('status')->default('active');     // active|pending|expired
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
