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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang upload
            $table->string('title');
            $table->string('author');
            $table->string('category'); // Kategori Prodi (TI, SI, dll)
            $table->string('cover_path')->nullable(); // Lokasi gambar sampul
            $table->string('file_path'); // Lokasi file .epub asli
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
