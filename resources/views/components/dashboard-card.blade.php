@props(['title', 'value', 'color' => 'text-gray-800'])

<div class="p-5 bg-white dark:bg-gray-800 rounded-xl shadow-md">
    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $title }}</h3>
    <p class="text-3xl font-bold mt-2 {{ $color }}">{{ $value }}</p>
</div>