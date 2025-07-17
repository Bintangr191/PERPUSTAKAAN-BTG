<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    @stack('styles')


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans antialiased">

@auth
<!-- Topbar -->
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-4 py-3 flex items-center justify-between">
        <!-- Burger button -->
        <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button"
            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none dark:text-gray-400 dark:hover:bg-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <span class="text-lg font-semibold text-gray-800 dark:text-white">Dashboard</span>

        <!-- User & Logout -->
        <div class="flex items-center space-x-3">
            <span class="text-gray-700 dark:text-white text-sm">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-600 hover:underline">Logout</button>
            </form>
                    <! -- togle -->
        {{-- <button id="toggleDark" class="px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded">
             Toggle Mode
        </button> --}}
<!-- Toggle Dark Mode -->
<button id="toggleDark"
    class="flex items-center gap-2 px-3 py-1.5 rounded-md text-sm font-medium 
           bg-gray-200 text-gray-800 hover:bg-gray-300 
           dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600 
           transition-colors duration-200">
    <i id="darkIcon" class="fa-solid fa-sun hidden dark:inline"></i>
    <i id="lightIcon" class="fa-solid fa-moon dark:hidden"></i>
    Mode
</button>

        </div>
    </div>
</nav>

<!-- Sidebar (drawer) -->
<aside id="sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700 md:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full flex flex-col justify-between px-3 py-4 overflow-y-auto">
        
        <!-- Bagian menu utama -->
        <ul class="space-y-2">
            <li>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 rounded"><i class="fas fa-house"></i>Dashboard</a>
            </li>
            <li>
            <a href="{{ route('buku.index') }}" class="block px-3 py-2 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 rounded"><i class="fas fa-book mr-2"></i> Buku</a>
            </li>
            <li>
            <a href="{{ route('user_perpustakaan.index') }}" class="block px-3 py-2 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 rounded"><i class="fas fa-users mr-2"></i> User</a>
            </li>
            <li>
            <a href="{{ route('peminjaman.index') }}" class="block px-3 py-2 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 rounded"><i class="fas fa-exchange-alt mr-2"></i> Peminjaman</a>
            </li>
        </ul>

        <!-- Bagian profil di paling bawah -->
        <div class="pt-4 border-t border-gray-300 dark:border-gray-700">
        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 rounded"><i class="fas fa-user mr-2"></i> Profil </a>
        </div>
    </div>
</aside>
@endauth

<!-- Main content -->
<div class="pt-16 md:ml-64">
    <main class="p-4">
        @if (isset($header))
        <header class="mb-4">
            <div class="max-w-7xl mx-auto">{{ $header }}</div>
        </header>
        @endif

        {{ $slot }}
    </main>
</div>
@stack('scripts')
    
<script>
    // Paksa reload saat back/forward
    if (performance.navigation.type === 2) {
        location.reload();
    }

  const toggle = document.getElementById('toggleDark');
  const html = document.documentElement;

  // Cek preferensi user sebelumnya
  if (localStorage.getItem('theme') === 'dark') {
    html.classList.add('dark');
  }

  toggle.addEventListener('click', () => {
    html.classList.toggle('dark');

    // Simpan preferensi ke localStorage
    if (html.classList.contains('dark')) {
      localStorage.setItem('theme', 'dark');
    } else {
      localStorage.setItem('theme', 'light');
    }
  });
</script>


</body>
</html>