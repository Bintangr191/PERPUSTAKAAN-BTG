<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserPerpustakaanController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
    // Route resource user perpustakaan (dengan parameter disingkat 'user')
    Route::resource('user_perpustakaan', UserPerpustakaanController::class)->parameters([
        'user_perpustakaan' => 'user'
    ]);

    Route::resource('buku', BukuController::class)->parameters([
        'buku' => 'buku'
    ]);

    Route::resource('peminjaman', PeminjamanController::class)->parameters([
        'peminjaman' => 'peminjaman'
    ]);

    // Route tambahan AJAX untuk get kode kartu
    Route::get('/get-kode-kartu/{pekerjaan}', [UserPerpustakaanController::class, 'getKodeKartu']);
    // Route tambahan AJAX untuk get detail buku
    Route::get('/buku/{id}/detail', [BukuController::class, 'show']);

    Route::put('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');

    // Route profil user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
