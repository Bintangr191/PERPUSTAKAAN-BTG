<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPerpustakaan; 
use Illuminate\Support\Facades\File;

class UserPerpustakaanController extends Controller
{
    public function index()
    {
        $users = UserPerpustakaan::all();
        return view('user_perpustakaan.index', compact('users'));
    }

    public function create()
    {
        return view('user_perpustakaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:user_perpustakaan,email',
            'telepon' => 'required|string',
            'pekerjaan' => 'required|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_tinggal' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $kodeKartu = $this->generateKodeKartu($request->input('pekerjaan'));

        $filename = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto_user'), $filename);
        }

        UserPerpustakaan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'pekerjaan' => $request->pekerjaan,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_tinggal' => $request->tempat_tinggal,
            'foto' => $filename,
            'kode_kartu' => $kodeKartu,
        ]);

        return redirect()->route('user_perpustakaan.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(UserPerpustakaan $user)
    {
        return view('user_perpustakaan.edit', compact('user'));
    }

    public function update(Request $request, UserPerpustakaan $user)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:user_perpustakaan,email,' . $user->id,
            'kode_kartu' => 'required|string|unique:user_perpustakaan,kode_kartu,' . $user->id,
            'telepon' => 'required|string',
            'pekerjaan' => 'required|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_tinggal' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user->update($request->all());

        $filename = $user->foto; // Simpan nama file lama
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto_user'), $filename);
        }

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'kode_kartu' => $request->kode_kartu,
            'telepon' => $request->telepon,
            'pekerjaan' => $request->pekerjaan,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_tinggal' => $request->tempat_tinggal,
            'foto' => $filename,
        ]);

        return redirect()->route('user_perpustakaan.index')->with('success', 'User berhasil diperbarui.');
    }

    public function generateKodeKartu($pekerjaan)
    {
        $pekerjaanLower = strtolower($pekerjaan);

        $prefix = match ($pekerjaanLower) {
            'mahasiswa' => 'MHSW',
            'pelajar'   => 'PLJR',
            'dosen'     => 'DSN',
            'staff'     => 'STF',
            'umum'      => 'UMUM',
            default     => 'USR',
        };

        // Cari kode terakhir yang ada dengan prefix itu
        $lastUser = UserPerpustakaan::where('kode_kartu', 'like', $prefix . '-%')
            ->orderByRaw("CAST(SUBSTRING(kode_kartu, LENGTH('$prefix-') + 1) AS UNSIGNED) DESC")
            ->first();

        if ($lastUser) {
            // Ambil angka terakhir
            $lastNumber = (int) str_replace($prefix . '-', '', $lastUser->kode_kartu);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function getKodeKartu($pekerjaan)
    {
        $kode = $this->generateKodeKartu($pekerjaan);
        return response()->json(['kode_kartu' => $kode]);
    }

  public function destroy(UserPerpustakaan $user)
    {
        // Cek apakah user punya peminjaman aktif (status dipinjam)
        if ($user->peminjaman()->where('status', 'dipinjam')->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'User masih memiliki buku yang belum dikembalikan.'
            ]);
        }

        // Hapus file foto jika ada
        if ($user->foto && file_exists(public_path('foto_user/' . $user->foto))) {
            File::delete(public_path('foto_user/' . $user->foto));
        }

        // Hapus user
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus.'
        ]);
    }


}