<x-app-layout>
    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Form Tambah Peminjaman</h2>

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600 dark:text-red-400">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="kode_kartu" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Kode Kartu User</label>
                    <input type="text" name="kode_kartu" id="kode_kartu" class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" value="{{ old('kode_kartu') }}" required>
                </div>

                <div class="mb-4">
                    <label for="buku_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Pilih Buku</label>
                    <select name="buku_id" id="buku_id" class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach ($bukus as $buku)
                            <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                {{ $buku->nama_buku }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="tanggal_pinjam" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" value="{{ old('tanggal_pinjam', $today) }}" min="{{ $today }}" max="{{ $today }}" required>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>