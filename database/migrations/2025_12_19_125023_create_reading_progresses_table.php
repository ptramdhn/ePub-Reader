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
        Schema::create('reading_progresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->string('last_cfi')->nullable(); // Lokasi terakhir (titik baca)
            $table->float('percentage')->default(0); // Progress 0-100%
            $table->integer('total_seconds')->default(0); // Total waktu baca (detik)
            $table->timestamps();

            // Pastikan 1 user cuma punya 1 record per buku
            $table->unique(['user_id', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reading_progresses');
    }
};
