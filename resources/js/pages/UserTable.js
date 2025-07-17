// import $ from 'jquery';
// import DataTable from 'datatables.net-dt';
// import Swal from 'sweetalert2';
// import toastr from 'toastr';
// // import 'datatables.net-dt/css/jquery.dataTables.min.css';

// $(document).ready(function () {
//     const table = $('#userTable').DataTable({
//         language: {
//             search: "Cari:",
//             lengthMenu: "Tampilkan MENU entri",
//             info: "Menampilkan START sampai END dari TOTAL entri",
//             paginate: {
//                 first: "Pertama",
//                 last: "Terakhir",
//                 next: "→",
//                 previous: "←"
//             },
//             zeroRecords: "Tidak ditemukan data yang sesuai",
//         }
//     });

//     $(document).on('click', '.delete-user', function () {
//         const id = $(this).data('id');
//         const rowSelector = `#user-row-${id}`;;

//         Swal.fire({
//             title: 'Yakin ingin menghapus user ini?',
//             icon: 'warning',
//             showCancelButton: true,
//             confirmButtonColor: '#e3342f',
//             cancelButtonColor: '#6c757d',
//             confirmButtonText: 'Ya, hapus!',
//             cancelButtonText: 'Batal'
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 fetch(`/user_perpustakaan/${id}`, {
//                     method: 'DELETE',
//                     headers: {
//                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//                         'Accept': 'application/json'
//                     }
//                 })
//                 .then(res => res.json())
//                 .then(data => {
//                     if (data.success) {
//                         Swal.fire('Terhapus!', data.message, 'success');
//                         const row = table.row($(rowSelector));
//                         row.remove().draw(false);
//                     } else {
//                         Swal.fire('Gagal', data.message || 'User tidak dapat dihapus.', 'error');
//                     }
//                 })
//                 .catch(error => {
//                     console.error('Error:', error);
//                     Swal.fire('Error', 'Terjadi kesalahan saat menghapus.', 'error');
//                 });
//             }
//         });
//     });
// });

//batal