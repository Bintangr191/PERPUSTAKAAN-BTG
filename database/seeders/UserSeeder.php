<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Perpus',
            'email' => 'admin@perpus123.com',
            'password' => Hash::make('password123'), // gunakan bcrypt atau hash
        ]);

        User::create([
            'name' => 'Petugas Biasa',
            'email' => 'petugas@perpus.com',
            'password' => Hash::make('password'),
        ]);
    }
}