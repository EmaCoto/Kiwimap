<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dateTime('overtime_start')->nullable()->after('clock_out');
            $table->dateTime('overtime_end')->nullable()->after('overtime_start');
            $table->unsignedInteger('overtime_seconds')->default(0)->after('overtime_end');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'overtime_start',
                'overtime_end',
                'overtime_seconds',
            ]);
        });
    }
};
