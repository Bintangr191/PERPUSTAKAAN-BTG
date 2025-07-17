<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPerpustakaan;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalUsers' => UserPerpustakaan::count(),
            'totalBooks' => Buku::count(),
            'booksAvailable' => Buku::where('status', true)->count(),
            'peminjamanAktif' => Peminjaman::where('status', 'dipinjam')->count(),
    ]);
    }
}