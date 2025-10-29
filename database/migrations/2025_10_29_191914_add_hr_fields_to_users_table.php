<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Identificación interna
            $table->string('employee_number', 50)->nullable()->after('remember_token');
            $table->boolean('has_id_badge')->default(false)->after('employee_number');

            // Fechas
            $table->date('birthday')->nullable()->after('has_id_badge');
            $table->date('anniversary_kiwimed')->nullable()->after('birthday');
            $table->date('anniversary_group')->nullable()->after('anniversary_kiwimed');

            // País (ISO-3166 alpha-2 en minúsculas, ej: "us","co","mx")
            $table->string('country_code', 2)->nullable()->after('anniversary_group');

            // Números opcionales
            $table->string('spruce_number', 50)->nullable()->after('country_code');
            $table->string('crecer_number', 50)->nullable()->after('spruce_number');

            // Índices útiles
            $table->index('employee_number');
            $table->index('country_code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Elimina índices antes de columnas (evita errores en algunos motores)
            $table->dropIndex(['employee_number']);
            $table->dropIndex(['country_code']);

            $table->dropColumn([
                'employee_number',
                'has_id_badge',
                'birthday',
                'anniversary_kiwimed',
                'anniversary_group',
                'country_code',
                'spruce_number',
                'crecer_number',
            ]);
        });
    }
};
