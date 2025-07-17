<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeders untuk tabel-tabel yang ada
        $this->call([
            UserSeeder::class,
        ]);
        
        // Jika ada seeder lain yang perlu dijalankan, tambahkan di sini
        // $this->call(AnotherSeeder::class);
        // $this->call(YetAnotherSeeder::class
    }
}
