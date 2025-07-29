@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-red-400 text-left text-base font-medium text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/20 focus:outline-none focus:text-red-800 dark:focus:text-red-200 focus:bg-red-100 dark:focus:bg-red-900/30 focus:border-red-700 dark:focus:border-red-300 transition duration-150 ease-in-out'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:border-red-300 dark:hover:border-red-700 focus:outline-none focus:text-red-600 dark:focus:text-red-400 focus:bg-red-50 dark:focus:bg-red-900/20 focus:border-red-300 dark:focus:border-red-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
