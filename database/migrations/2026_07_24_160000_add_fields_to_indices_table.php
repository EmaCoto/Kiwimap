<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('indices', function (Blueprint $table) {
            $table->string('name', 150)->after('id');
            $table->string('information', 100)->after('name');
            $table->text('notes')->nullable()->after('information');
        });
    }

    public function down(): void
    {
        Schema::table('indices', function (Blueprint $table) {
            $table->dropColumn(['name', 'information', 'notes']);
        });
    }
};
