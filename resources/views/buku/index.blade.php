<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Daftar Buku</h2>
                <a href="{{ route('buku.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Tambah Buku
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 text-sm text-green-600 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table id="bukuTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">
                        <tr>
                            <th class="px-4 py-2">NO</th>
                            <th class="px-4 py-2">Gambar</th>
                            <th class="px-4 py-2">Nama Buku</th>
                            <th class="px-4 py-2">Genre</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-200 text-sm">
                        @foreach ($bukus as $buku)
                            <tr>
                                <td> </td>
                                <td class="px-4 py-2">
                                    @if($buku->gambar)
                                        <img src="{{ asset('gambar_buku/' . $buku->gambar) }}" alt="Gambar Buku" loading="lazy" class="w-12 h-12 object-cover rounded">
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $buku->nama_buku }}</td>
                                <td class="px-4 py-2">{{ $buku->genre }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded 
                                        {{ $buku->status ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                        {{ $buku->status ? 'Tersedia' : 'Tidak Tersedia' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <div class="flex gap-2">
                                        <a href="{{ route('buku.edit', $buku->id) }}"
                                           class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-xs">Edit</a>
                                        <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs delete-buku"
                                            data-id="{{ $buku->id }}">
                                            Hapus
                                        </button>
                                        <button type="button"
                                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs"
                                            onclick="showDetail({{ $buku->id }})">
                                            Detail
                                        </button>
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
        <!-- jQuery dan DataTables -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

        <script>
        $(document).ready(function () {
            var table = $('#bukuTable').DataTable({
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
                // Koreksi: Ganti selector ke yang benar
                $('div.dataTables_length select').addClass(
                    'bg-white dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded px-3 py-1 appearance-none pr-10'
                ).css({
                    'background-position': 'left 1.1rem center',
                    'background-repeat': 'no-repeat',
                    'background-size': '1rem 1rem'
                });

                // Tambah padding agar ^ tidak menimpa angka
                $('div.dataTables_length').addClass('relative');

                // Tambahkan caret custom (opsional agar konsisten)
                $('div.dataTables_length').append(`
                    <style>
                        .dataTables_length select {
                            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='gray' viewBox='0 0 24 24'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
                        }
                    </style>
                `);
            },
                columnDefs: [
                    {
                        targets: 0, // index kolom pertama (kolom No)
                        searchable: false,
                        orderable: false,
                    }
                ],
                order: [[1, 'asc']], // kolom ke-1 (nama buku) yang diurutkan
            });

            table.on('order.dt search.dt', function () {
                let i = 1;

                table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function () {
                    this.data(i++);
                });
            }).draw();
        });

        function showDetail(id) {
            fetch(`/buku/${id}/detail`)
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        title: `<div class="text-lg font-semibold text-gray-800">${data.nama_buku}</div>`,
                    html: `
                        <div class="flex flex-col md:flex-row items-center justify-center gap-6 text-sm text-left">
                            <!-- Gambar -->
                            <div class="w-40 h-52 overflow-hidden rounded border border-gray-300 shadow-sm bg-white">
                                ${data.gambar ? `<img src="${data.gambar}" alt="Gambar Buku" loading="lazy" class="w-full h-full object-cover">` : `<div class="flex items-center justify-center h-full text-gray-400">Tidak ada gambar</div>`}
                            </div>

                            <!-- Informasi -->
                            <div class="flex flex-col space-y-1 text-gray-700">
                                <p><span class="font-semibold">Genre:</span> ${data.genre}</p>
                                <p><span class="font-semibold">Penulis:</span> ${data.penulis}</p>
                                <p><span class="font-semibold">Penerbit:</span> ${data.penerbit}</p>
                                <p><span class="font-semibold">Tanggal Terbit:</span> ${data.tanggal_terbit}</p>
                                <p>
                                    <span class="font-semibold">Status:</span> 
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium rounded 
                                        ${data.status === 'Tersedia' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}">
                                        ${data.status}
                                    </span>
                                </p>
                                <p><span class="font-semibold">Dibuat:</span> ${data.created_at}</p>
                                <p><span class="font-semibold">Diubah:</span> ${data.updated_at}</p>
                            </div>
                        </div>
                    `,
                        showCloseButton: true,
                        confirmButtonText: 'Tutup',
                        focusConfirm: false,
                        width: 550,
                        customClass: {
                            popup: 'rounded-lg shadow-md'
                        }
                    });
                })
                .catch(error => {
                    console.error('Gagal mengambil detail buku:', error);
                    Swal.fire('Error', 'Terjadi kesalahan saat memuat detail buku.', 'error');
                });
        }

        $(document).on('click', '.delete-buku', function () {
            const id = $(this).data('id');
            const row = $(this).closest('tr');

            Swal.fire({
                title: 'Yakin ingin menghapus buku ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/buku/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Terhapus!', data.message, 'success');

                            const table = $('#bukuTable').DataTable();
                            table.row(row).remove().draw(false);
                        } else {
                            Swal.fire('Gagal', data.message || 'Tidak dapat menghapus buku.', 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', 'Terjadi kesalahan saat menghapus buku.', 'error');
                    });
                }
            });
        });


        </script>
    @endpush
</x-app-layout>