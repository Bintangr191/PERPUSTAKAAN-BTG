<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_perpustakaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('kode_kartu')->unique(); // nanti bisa digenerate otomatis
            $table->string('telepon');
            $table->string('pekerjaan')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('tempat_tinggal')->nullable();
            $table->string('foto')->nullable(); // opsional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_perpustakaan');
    }
};
