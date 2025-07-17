<x-app-layout>
    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Tambah Buku</h2>

            @include('buku.form', [
                'action' => route('buku.store'),
                'isEdit' => false,
                'buku' => new \App\Models\Buku()
            ])
        </div>
    </div>
</x-app-layout>