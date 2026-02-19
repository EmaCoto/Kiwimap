<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Día laboral lógico (según la TZ capturada)
            $table->date('work_date')->index();
            $table->string('timezone', 64)->default(config('app.timezone', 'UTC'));

            // Marcas
            $table->dateTime('clock_in')->nullable();
            $table->dateTime('break1_start')->nullable();
            $table->dateTime('break1_end')->nullable();
            $table->dateTime('break2_start')->nullable();
            $table->dateTime('break2_end')->nullable();
            $table->dateTime('lunch_start')->nullable();
            $table->dateTime('lunch_end')->nullable();
            $table->dateTime('clock_out')->nullable();

            // Estado simple para UI
            $table->string('status', 30)->default('offline'); // offline|working|break1|break2|lunch|clocked_out

            $table->timestamps();

            // Un registro de asistencia por usuario+día
            $table->unique(['user_id', 'work_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
