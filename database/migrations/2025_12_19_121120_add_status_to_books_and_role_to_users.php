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
        // Tambah status di tabel books
        Schema::table('books', function (Blueprint $table) {
            // Pilihan: pending, approved, rejected
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('file_path');
            // Tambahan: alasan penolakan (opsional)
            $table->text('rejection_reason')->nullable()->after('status');
        });

        // Tambah penanda admin di tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
