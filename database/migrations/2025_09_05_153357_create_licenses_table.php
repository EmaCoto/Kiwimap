<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('state_id')->constrained()->cascadeOnDelete();

            // Eliminamos: license_number, license_type, dea_number
            // Fechas opcionales
            $table->date('issued_date')->nullable();
            $table->date('expiration_date')->nullable();

            // Checkbox: ¿existe link/verificación activa?
            $table->boolean('has_active_link')->default(false);

            // Puedes conservar columnas extra si las usas más adelante:
            $table->string('expired_license_link')->nullable(); // opcional
            $table->text('notes')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->boolean('mal_praxis_required')->default(false);
            $table->json('forms')->nullable();
            $table->boolean('need_physical_office')->default(false);
            $table->json('insurance')->nullable();
            $table->string('status')->default('active'); // active|pending|expired
            $table->timestamps();

            // Opcional: índice compuesto para combinaciones doctor-estado
            $table->unique(['doctor_id','state_id','issued_date'], 'licenses_unique_doctor_state_issued');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
