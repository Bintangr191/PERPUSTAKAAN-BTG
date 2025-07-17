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

    <!-- Nama -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
        <input type="text" name="nama" value="{{ old('nama', $user->nama ?? '') }}"
            class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border rounded-lg text-gray-900 dark:text-white">
    </div>

    <!-- Email & Telepon -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border rounded-lg text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telepon</label>
            <input type="text" name="telepon" value="{{ old('telepon', $user->telepon ?? '') }}"
                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border rounded-lg text-gray-900 dark:text-white">
        </div>
    </div>

    <!-- Kode Kartu & Pekerjaan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Kartu</label>
            <input type="text" name="kode_kartu" id="kode_kartu" readonly
                value="{{ old('kode_kartu', $user->kode_kartu ?? '') }}"
                class="w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 border rounded-lg text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pekerjaan</label>
            <select name="pekerjaan" id="pekerjaan"
                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border rounded-lg text-gray-900 dark:text-white">
                <option value="">-- Pilih Pekerjaan --</option>
                @foreach(['Mahasiswa', 'Pelajar', 'Dosen', 'Staff', 'Umum'] as $p)
                    <option value="{{ $p }}" {{ old('pekerjaan', $user->pekerjaan ?? '') == $p ? 'selected' : '' }}>
                        {{ $p }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Foto -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto (Opsional)</label>
        <input type="file" name="foto" accept="image/*"
            class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border rounded-lg text-gray-900 dark:text-white">

        {{-- Jika sedang edit dan ada foto lama --}}
        @if ($isEdit && !empty($user->foto))
            <div class="mt-3">
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Foto Sebelumnya:</p>
                <img src="{{ asset('foto_user/' . $user->foto) }}" alt="Foto Lama" loading="lazy"
                     onerror="this.onerror=null; this.src='{{ asset('foto_user/default.png') }}'"
                    class="w-24 h-24 object-cover rounded border border-gray-300 dark:border-gray-600">
            </div>

            {{-- Simpan nama file lama dalam hidden input --}}
            <input type="hidden" name="foto_lama" value="{{ $user->foto }}">
        @endif
    </div>

    <!-- Tempat & Tanggal Lahir -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir ?? '') }}"
                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border rounded-lg text-gray-900 dark:text-white">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir ?? '') }}"
                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border rounded-lg text-gray-900 dark:text-white">
        </div>
    </div>

    <!-- Jenis Kelamin -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Kelamin</label>
        <div class="flex gap-6">
            <label class="flex items-center">
                <input type="radio" name="jenis_kelamin" value="L"
                    {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'L' ? 'checked' : '' }}
                    class="text-blue-600 focus:ring-blue-500 dark:bg-gray-700">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Laki-laki</span>
            </label>
            <label class="flex items-center">
                <input type="radio" name="jenis_kelamin" value="P"
                    {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'P' ? 'checked' : '' }}
                    class="text-blue-600 focus:ring-blue-500 dark:bg-gray-700">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Perempuan</span>
            </label>
        </div>
    </div>

    <!-- Alamat -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Lengkap</label>
        <textarea name="tempat_tinggal" rows="3"
            class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border rounded-lg text-gray-900 dark:text-white resize-none">{{ old('tempat_tinggal', $user->tempat_tinggal ?? '') }}</textarea>
    </div>

    <!-- Tombol -->
    <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('user_perpustakaan.index') }}"
            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md">
            Batal
        </a>
        <button type="submit"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
            {{ $isEdit ? 'Perbarui' : 'Simpan' }}
        </button>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pekerjaan = document.getElementById('pekerjaan');
        if (pekerjaan) {
            pekerjaan.addEventListener('change', function () {
                const val = this.value;
                if (val) {
                    fetch(`/get-kode-kartu/${val}`)
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('kode_kartu').value = data.kode_kartu;
                        })
                        .catch(err => console.error(err));
                } else {
                    document.getElementById('kode_kartu').value = '';
                }
            });
        }
    });
</script>
@endpush