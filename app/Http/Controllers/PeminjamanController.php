<?php
namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\UserPerpustakaan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('user', 'buku')->latest()->get();
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $bukus = Buku::where('status', true)->get(); // hanya buku yang tersedia
        $today = Carbon::now()->format('Y-m-d'); // format tanggal untuk input date

        return view('peminjaman.create', compact('bukus', 'today'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kartu' => 'required|string|exists:user_perpustakaan,kode_kartu',
            'buku_id' => 'required|exists:buku,id',
            'tanggal_pinjam' => ['required', 'date', 'date_equals:' . now()->toDateString()],
        ]);

        $user = UserPerpustakaan::where('kode_kartu', $request->kode_kartu)->first();

        if (!$user) {
            return back()->withErrors(['kode_kartu' => 'Kode kartu tidak ditemukan.'])->withInput();
        }

        $peminjaman = Peminjaman::create([
            'user_id' => $user->id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status' => 'dipinjam',
        ]);

        // Ubah status buku jadi tidak tersedia
        Buku::where('id', $request->buku_id)->update(['status' => false]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    // public function show(Peminjaman $peminjaman)
    // {
    //     return view('peminjaman.show', compact('peminjaman'));
    // }

    // public function edit(Peminjaman $peminjaman)
    // {
    //     $bukus = Buku::all();
    //     return view('peminjaman.edit', compact('peminjaman', 'bukus'));
    // }

    public function kembalikan($id)
    {
        // Ambil peminjaman dan sekaligus relasi bukunya
        $peminjaman = Peminjaman::with('buku')->findOrFail($id);

        // Cek jika status sudah "kembali"
        if ($peminjaman->status === 'kembali') {
            return response()->json(['success' => false, 'message' => 'Buku sudah dikembalikan.']);
        }

        // Update status peminjaman dan tanggal kembali
        $peminjaman->update([
            'tanggal_kembali' => Carbon::now(),
            'status' => 'kembali',
        ]);

        // Cek dulu relasi buku-nya ada
        if ($peminjaman->buku) {
            $peminjaman->buku->update(['status' => 1]); // 1 = tersedia
        } else {
            return response()->json(['success' => false, 'message' => 'Relasi buku tidak ditemukan.']);
        }

        return response()->json(['success' => true, 'message' => 'Buku berhasil dikembalikan.']);
    }

}