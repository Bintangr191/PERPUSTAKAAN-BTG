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
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('nama_buku');
            $table->date('tanggal_buku');
            $table->string('genre');
            $table->string('penulis');
            $table->string('penerbit');
            $table->string('gambar')->nullable();
            $table->boolean('status')->default(true); // status buku, true = tersedia, false = tidak tersedia
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
