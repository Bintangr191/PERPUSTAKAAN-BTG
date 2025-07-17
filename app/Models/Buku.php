<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'nama_buku',
        'tanggal_buku',
        'genre',
        'penulis',
        'penerbit',
        'gambar',
        'status', 
    ];

    public function peminjaman()
    {
        return $this->hasMany(\App\Models\Peminjaman::class, 'buku_id');
    }
}
