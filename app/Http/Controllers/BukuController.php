<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\File;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::all();
        return view('buku.index', compact('bukus'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_buku' => 'required|string|max:255',
            'tanggal_buku' => 'required|date',
            'genre' => 'required|string',
            'penulis' => 'required|string',
            'penerbit' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean'
        ]);

        $filename = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('gambar_buku'), $filename);
        }

        Buku::create([
            'nama_buku' => $request->nama_buku,
            'tanggal_buku' => $request->tanggal_buku,
            'genre' => $request->genre,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'gambar' => $filename,
            'status' => $request->status
        ]);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'nama_buku' => 'required|string|max:255',
            'tanggal_buku' => 'required|date',
            'genre' => 'required|string',
            'penulis' => 'required|string',
            'penerbit' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean'
        ]);

        $filename = $buku->gambar;

        if ($request->hasFile('gambar')) {
            if ($filename && File::exists(public_path('gambar_buku/' . $filename))) {
                File::delete(public_path('gambar_buku/' . $filename));
            }

            $file = $request->file('gambar');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('gambar_buku'), $filename);
        }

        $buku->update([
            'nama_buku' => $request->nama_buku,
            'tanggal_buku' => $request->tanggal_buku,
            'genre' => $request->genre,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'gambar' => $filename,
            'status' => $request->status
        ]);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function show($id)
    {
        $buku = Buku::findOrFail($id);

        return response()->json([
            'nama_buku' => $buku->nama_buku,
            'genre' => $buku->genre,
            'penulis' => $buku->penulis,
            'penerbit' => $buku->penerbit,
            'tanggal_terbit' => $buku->tanggal_buku,
            'status' => $buku->status ? 'Tersedia' : 'Tidak Tersedia',
            'gambar' => $buku->gambar ? asset('gambar_buku/' . $buku->gambar) : null,
            'created_at' => $buku->created_at->format('d-m-Y H:i'),
            'updated_at' => $buku->updated_at->format('d-m-Y H:i'),
    ]);
    }

    public function destroy(Buku $buku)
    {
        // Cek apakah buku sedang dipinjam
        if ($buku->peminjaman()->where('status', 'dipinjam')->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Buku sedang dipinjam dan tidak dapat dihapus.'
            ]);
        }

        // Hapus gambar jika ada
        if ($buku->gambar && File::exists(public_path('gambar_buku/' . $buku->gambar))) {
            File::delete(public_path('gambar_buku/' . $buku->gambar));
        }

        $buku->delete();

        return response()->json(['success' => true, 'message' => 'Data buku berhasil dihapus.']);
    }
}