<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPerpustakaan extends Model
{
    use HasFactory;

    protected $table = 'user_perpustakaan';

    protected $fillable = [
        'nama',
        'email',
        'kode_kartu',
        'telepon',
        'pekerjaan',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'tempat_tinggal',
        'foto',
];

    public function peminjaman()
    {
        return $this->hasMany(\App\Models\Peminjaman::class, 'user_id');
    }
}