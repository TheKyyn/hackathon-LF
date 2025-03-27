<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gradient-to-b from-dark-50 to-white">
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-heading font-bold text-primary-600">
                        {{ config('app.name', 'Lead Factory') }}
                    </a>
                </div>
                <nav class="flex space-x-4">
                    <a href="{{ route('home') }}" class="text-dark-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium">Accueil</a>
                    @if(Route::has('admin.leads.index'))
                        <a href="{{ route('admin.leads.index') }}" class="text-dark-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium">Administration</a>
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <footer class="bg-dark-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">{{ config('app.name', 'Lead Factory') }}</h3>
                    <p class="text-dark-300 text-sm">
                        Collectez facilement des leads qualifiés pour vos projets de panneaux photovoltaïques et pompes à chaleur.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2 text-sm text-dark-300">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Mentions légales</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Politique de confidentialité</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <p class="text-dark-300 text-sm">
                        Email: contact@example.com<br>
                        Téléphone: +33 1 23 45 67 89
                    </p>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-dark-700 text-center text-dark-400 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name', 'Lead Factory') }}. Tous droits réservés.
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
