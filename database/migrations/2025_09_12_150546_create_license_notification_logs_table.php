<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('license_notification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('license_id')->constrained()->cascadeOnDelete();
            $table->smallInteger('offset_days');
            $table->timestamp('sent_at');
            $table->timestamps();

            $table->unique(['license_id','offset_days'], 'uniq_license_offset');
        });
    }

    public function down(): void {
        Schema::dropIfExists('license_notification_logs');
    }
};
