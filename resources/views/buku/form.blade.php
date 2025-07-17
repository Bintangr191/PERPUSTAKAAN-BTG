@if ($errors->any())
    <div class="mb-4 bg-red-100 dark:bg-red-900/20 border border-red-300 dark:border-red-700 p-4 rounded">
        <ul class="text-sm text-red-600 dark:text-red-300 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <!-- Nama Buku -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Buku</label>
        <input type="text" name="nama_buku" value="{{ old('nama_buku', $buku->nama_buku ?? '') }}"
            class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border rounded-lg text-gray-900 dark:text-white">
    </div>

    <!-- Genre & Tanggal Buku -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Genre</label>
            <input type="text" name="genre" value="{{ old('genre', $buku->genre ?? '') }}"
                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border rounded-lg text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Buku</label>
            <input type="date" name="tanggal_buku" value="{{ old('tanggal_buku', $buku->tanggal_buku ?? '') }}"
                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border rounded-lg text-gray-900 dark:text-white">
        </div>
    </div>

    <!-- Penulis & Penerbit -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Penulis</label>
            <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis ?? '') }}"
                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border rounded-lg text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Penerbit</label>
            <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit ?? '') }}"
                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border rounded-lg text-gray-900 dark:text-white">
        </div>
    </div>

    <!-- Gambar -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gambar Buku</label>
        <input type="file" name="gambar" class="w-full border-gray-300 bg-gray-50 dark:bg-gray-700 text-white">

        @if ($isEdit && $buku->gambar)
            <div class="mt-3">
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Gambar Lama:</p>
                <img src="{{ asset('gambar_buku/' . $buku->gambar) }}" alt="Gambar Buku" class="w-24 h-24 object-cover rounded border border-gray-300 dark:border-gray-600">
            </div>
            <input type="hidden" name="gambar_lama" value="{{ $buku->gambar }}">
        @endif
    </div>

    <!-- Status -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Buku</label>
        <select name="status" class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border rounded-lg text-gray-900 dark:text-white">
            <option value="1" {{ old('status', $buku->status ?? 1) == 1 ? 'selected' : '' }}>Tersedia</option>
            <option value="0" {{ old('status', $buku->status ?? 1) == 0 ? 'selected' : '' }}>Tidak Tersedia</option>
        </select>
    </div>

    <!-- Tombol -->
    <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('buku.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md">Batal</a>
        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
            {{ $isEdit ? 'Perbarui' : 'Simpan' }}
        </button>
    </div>
</form>