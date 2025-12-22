<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
            Schema::table('reading_progress', function (Blueprint $table) {
            // Kolom untuk menyimpan total durasi baca dalam detik (default 0)
            // Ditaruh setelah kolom percentage biar rapi
            $table->integer('total_seconds')->default(0)->after('percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reading_progress', function (Blueprint $table) {
            //
        });
    }
};
