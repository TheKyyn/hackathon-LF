<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lead Factory') }}</title>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Lead Factory
            </h1>
        </div>
    </header>

    <main>
        {{ $slot ?? $content ?? '' }}
    </main>

    <footer class="bg-white shadow mt-10 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-600">&copy; {{ date('Y') }} Lead Factory. Tous droits réservés.</p>
                </div>
                <div>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Mentions légales</a>
                    <span class="mx-2 text-gray-400">|</span>
                    <a href="#" class="text-blue-600 hover:text-blue-800">Politique de confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
