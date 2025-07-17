<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Daftar User Perpustakaan</h2>
                <a href="{{ route('user_perpustakaan.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Tambah User
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 text-sm text-green-600 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table id="userTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">ID Kartu</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Pekerjaan</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-200 text-sm">
                        @foreach ($users as $user)
                            <tr id="user-row-{{ $user->id }}" class="border-b dark:border-gray-700">
                                <td class="px-4 py-2"></td>
                                <td class="px-4 py-2">{{ $user->kode_kartu }}</td>
                                <td class="px-4 py-2">{{ $user->nama }}</td>
                                <td class="px-4 py-2">{{ $user->pekerjaan }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2">
                                    <div class="flex gap-2">
                                        <a href="{{ route('user_perpustakaan.edit', $user->id) }}"
                                           class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-xs">Edit</a>
                                        <button type="button"
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs delete-user"
                                            data-id="{{ $user->id }}">
                                            Hapus
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
<!-- Toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush


    @push('scripts')
    <!-- Tambahkan jQuery dan DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        function handleDelete(id) {
            if (confirm('Yakin ingin menghapus user ini?')) {
                document.getElementById(`form-delete-${id}`).submit();
            }
        }

        $(document).ready(function () {
            $('#userTable').DataTable({
                columnDefs: [
                    { targets: 0, searchable: false, orderable: false }
                ],
                order: [[1, 'asc']],
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
                },
                drawCallback: function () {
                    let api = this.api();
                    api.column(0, { search: 'applied', order: 'applied' }).nodes().each((cell, i) => {
                        cell.innerHTML = i + 1;
                   });
                }
            });
        });


$(document).on('click', '.delete-user', function () {
    const id = $(this).data('id');
    const rowSelector = `#user-row-${id}`;
    const table = $('#userTable').DataTable();

    Swal.fire({
        title: 'Yakin ingin menghapus user ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/user_perpustakaan/${id}`, {
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

                    // Hapus dari DataTable dan DOM tanpa reload
                    const row = table.row($(rowSelector));
                    row.remove().draw(false); // false agar tidak pindah ke page 1
                } else {
                    Swal.fire('Gagal', data.message || 'User tidak dapat dihapus.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat menghapus.', 'error');
            });
        }
    });
});

    </script>
    @endpush
</x-app-layout>