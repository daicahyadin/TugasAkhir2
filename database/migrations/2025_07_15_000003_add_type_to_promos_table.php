<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            // Sudah ada di migrasi utama, tidak perlu ditambah lagi
        });
    }

    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            // Sudah ada di migrasi utama, tidak perlu di-drop di sini
        });
    }
}; 