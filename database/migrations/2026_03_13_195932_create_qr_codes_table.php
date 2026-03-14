<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // text, url, email, phone, whatsapp, wifi
            $table->json('payload')->nullable(); // datos originales
            $table->text('content'); // contenido final codificado en el QR
            $table->string('foreground_color')->default('#000000');
            $table->string('background_color')->default('#FFFFFF');
            $table->integer('size')->default(600);
            $table->string('logo_path')->nullable();
            $table->string('qr_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};
