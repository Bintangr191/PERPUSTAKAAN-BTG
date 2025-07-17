<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();

            // Foreign key ke user_perpustakaan 
            $table->foreignId('user_id')->constrained('user_perpustakaan')->onDelete('cascade');

            // Foreign key ke buku
            $table->foreignId('buku_id')->constrained('buku')->onDelete('cascade');

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable(); // null kalau belum dikembalikan

            $table->enum('status', ['dipinjam', 'kembali'])->default('dipinjam');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};