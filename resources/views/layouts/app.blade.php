<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('notebook.png') }}">
        <title>{{ config('app.name') }}</title>

        <!-- Chrome Icon -->
        <link rel="icon" href="{{ asset('notebook.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine.js for Dark Mode Toggle -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            <footer class="border-t border-gray-200 bg-white dark:bg-gray-800 py-6 mt-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500 dark:text-gray-300">
                    <div class="mb-2 md:mb-0">
                        &copy; {{ date('Y') }} My To-Do App. All rights reserved.
                    </div>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-gray-700 dark:hover:text-white">Privacy</a>
                        <a href="#" class="hover:text-gray-700 dark:hover:text-white">Terms</a>
                        <a href="https://github.com/Aly-Mohsen/todo-app" class="hover:text-gray-700 dark:hover:text-white">GitHub</a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
