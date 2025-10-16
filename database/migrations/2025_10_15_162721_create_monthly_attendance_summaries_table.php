<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('monthly_attendance_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Guardamos el mes como primer día del mes para facilitar índices (ej. 2025-10-01)
            $table->date('month')->index();
            $table->string('timezone', 64)->default(config('app.timezone', 'UTC'));
            $table->unsignedBigInteger('total_seconds')->default(0);
            $table->timestamps();

            $table->unique(['user_id','month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_attendance_summaries');
    }
};
