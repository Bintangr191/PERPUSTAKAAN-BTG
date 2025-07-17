<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="min-h-screen flex flex-col justify-center items-center px-4">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-blue-600 mb-2">Selamat Datang di Sistem Perpustakaan</h1>
            <p class="text-lg text-gray-600 mb-6">Kelola buku, anggota, dan peminjaman dengan mudah dan cepat.</p>
            <div class="mt-6">
                <a href="{{ route('login') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
                    Masuk ke Dashboard
                </a>
            </div>
        </div>

        <div class="mt-12 max-w-3xl text-center text-sm text-gray-500">
            <p>Sistem ini dibangun menggunakan Laravel, Tailwind, dan Vite.</p>
        </div>
    </div>
</body>
</html>