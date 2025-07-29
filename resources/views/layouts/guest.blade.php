<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MRM Kendari') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-red-50 via-white to-red-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500 shadow-2xl rounded-2xl bg-white p-2 ring-2 ring-red-200" />
                </a>
                <h1 class="mt-4 text-2xl font-bold text-red-600">MRM Kendari</h1>
                <p class="text-gray-600 dark:text-gray-400">Rajanya DAIHATSU di Indonesia Timur</p>
            </div>

            <div class="w-full sm:max-w-md px-6 py-8 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
