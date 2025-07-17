<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            Dashboard
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Selamat Datang -->
        <div class="p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Selamat Datang <i class="fa-brands fa-github"></i></h3>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                Hai <span class="font-semibold text-blue-600">{{ Auth::user()->name }}</span>, kamu login sebagai
                <span class="italic">{{ Auth::user()->email }}</span>
            </p>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <!-- Total User -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg border-l-4 border-blue-500">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Total User</h4>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalUsers }}</p>
            </div>

            <!-- Total Buku -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg border-l-4 border-purple-500">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Total Buku</h4>
                <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalBooks }}</p>
            </div>

            <!-- Buku Tersedia -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg border-l-4 border-green-500">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Buku Tersedia</h4>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ $booksAvailable }}</p>
            </div>

            <!-- Peminjaman Aktif -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg border-l-4 border-yellow-500">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Peminjaman Aktif</h4>
                <p class="text-3xl font-bold text-yellow-500 mt-2">{{ $peminjamanAktif }}</p>
            </div>
        </div>
    </div>
</x-app-layout>