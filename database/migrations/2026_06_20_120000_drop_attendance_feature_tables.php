<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('monthly_attendance_summaries');
        Schema::dropIfExists('attendances');
    }

    public function down(): void
    {
        // Attendance feature removed permanently.
    }
};