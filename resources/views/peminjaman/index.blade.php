<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Daftar Peminjaman</h2>
                <a href="{{ route('peminjaman.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                    + Tambah Peminjaman
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 text-sm text-green-600 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table id="peminjamanTable" class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Kode Kartu</th>
                            <th class="px-4 py-2">Nama User</th>
                            <th class="px-4 py-2">Buku</th>
                            <th class="px-4 py-2">Tgl Pinjam</th>
                            <th class="px-4 py-2">Tgl Kembali</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjamans as $peminjaman)
                            <tr id="peminjaman-row-{{ $peminjaman->id }}" class="border-b dark:border-gray-600">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $peminjaman->user->kode_kartu ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $peminjaman->user->nama ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $peminjaman->buku->nama_buku ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $peminjaman->tanggal_pinjam }}</td>
                                <td class="px-4 py-2 tgl-kembali-cell">{{ $peminjaman->tanggal_kembali ?? '-' }}</td>
                                <td class="px-4 py-2 status-cell">
                                    <span class="status-label px-2 py-1 rounded text-xs 
                                        {{ $peminjaman->status == 'dipinjam' ? 'bg-yellow-400 text-white' : 'bg-green-600 text-white' }}">
                                        {{ ucfirst($peminjaman->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <div class="flex gap-2">
                                        @if($peminjaman->status === 'dipinjam')
                                            <button type="button"
                                                data-id="{{ $peminjaman->id }}"
                                                class="kembalikan-buku px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs">
                                                Kembalikan
                                            </button>
                                        @else
                                            <span class="px-3 py-1 bg-gray-400 text-white rounded text-xs">Selesai</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    @endpush


    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
$(document).ready(function () {
    $('#peminjamanTable').DataTable({
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "→",
                previous: "←"
            },
            zeroRecords: "Tidak ditemukan data yang sesuai",
        },
        initComplete: function () {
            $('div.dataTables_length select').addClass(
                'bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded px-3 py-1 appearance-none pr-10'
            ).css({
                'background-position': 'left 1.1rem center',
                'background-repeat': 'no-repeat',
                'background-size': '1rem 1rem'
            });

            // Tambahkan caret custom (opsional)
            $('div.dataTables_length').append(`
                <style>
                    .dataTables_length select {
                        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='gray' viewBox='0 0 24 24'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
                    }
                </style>
            `);
        }
    });
});


$(document).on('click', '.kembalikan-buku', function () {
    const id = $(this).data('id');
    const row = $(this).closest('tr');
    const table = $('#peminjamanTable').DataTable();

    Swal.fire({
        title: 'Yakin mengembalikan buku?',
        text: "Tanggal kembali akan diisi otomatis.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, kembalikan!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/peminjaman/${id}/kembalikan`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Berhasil!', data.message, 'success');

                    // Tanggal kembali
                    const now = new Date();
                    const tanggalFormatted = now.getFullYear() + '-' +
                        String(now.getMonth() + 1).padStart(2, '0') + '-' +
                        String(now.getDate()).padStart(2, '0');

                    row.find('.tgl-kembali-cell').text(tanggalFormatted);

                    // Update status
                    const statusLabel = row.find('.status-cell .status-label');
                    statusLabel
                        .removeClass('bg-yellow-400')
                        .addClass('bg-green-600')
                        .text('Kembali');

                    // Hapus tombol kembalikan
                row.find('td:last').html(`<span class="px-3 py-1 bg-gray-400 text-white rounded text-xs">Selesai</span>`);
                } else {
                    Swal.fire('Gagal', data.message || 'Tidak dapat mengembalikan buku.', 'error');
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Terjadi kesalahan saat mengembalikan buku.', 'error');
            });
        }
    });
});



    </script>
    @endpush
</x-app-layout>