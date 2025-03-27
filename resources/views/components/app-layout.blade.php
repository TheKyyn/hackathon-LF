<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lead Factory') }}</title>

    <!-- Police Marianne -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@gouvfr/dsfr@1.9.3/dist/fonts/Marianne/fonts.css" />

    <!-- Styles personnalisés pour Marianne -->
    <style>
        @font-face {
            font-family: 'Marianne';
            src: url('{{ asset("fonts/Marianne-Regular.woff2") }}') format('woff2'),
                 url('{{ asset("fonts/Marianne-Regular.woff") }}') format('woff');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Marianne';
            src: url('{{ asset("fonts/Marianne-Bold.woff2") }}') format('woff2'),
                 url('{{ asset("fonts/Marianne-Bold.woff") }}') format('woff');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Marianne';
            src: url('{{ asset("fonts/Marianne-Light.woff2") }}') format('woff2'),
                 url('{{ asset("fonts/Marianne-Light.woff") }}') format('woff');
            font-weight: 300;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Marianne';
            src: url('{{ asset("fonts/Marianne-Medium.woff2") }}') format('woff2'),
                 url('{{ asset("fonts/Marianne-Medium.woff") }}') format('woff');
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }
    </style>

    <!-- Tailwind CSS via CDN (solution temporaire) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        marianne: ["Marianne", "sans-serif"],
                        sans: ["Marianne", "sans-serif"],
                    }
                }
            }
        }
    </script>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-marianne antialiased bg-white">
    <header class="bg-[#013565] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/landing/imgs/FIE-header.png') }}" alt="France Info Énergie" class="h-12 text-white" />
                    </a>
                </div>
                <div class="px-[30px] py-2.5 bg-[#41b99f]/20 rounded-[130px] outline outline-1 outline-offset-[-1px] outline-[#41b99f] inline-flex justify-center items-center gap-2">
                    <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.70018 2.90004C2.36881 2.65152 1.89871 2.71867 1.65018 3.05004C1.40165 3.38142 1.46881 3.85152 1.80018 4.10004L3.30018 5.22504C3.63155 5.47357 4.10165 5.40641 4.35018 5.07504C4.59871 4.74367 4.53155 4.27357 4.20018 4.02504L2.70018 2.90004Z" fill="white"/>
                        <path d="M16.2002 4.10004C16.5315 3.85152 16.5987 3.38142 16.3502 3.05004C16.1017 2.71867 15.6315 2.65152 15.3002 2.90004L13.8002 4.02504C13.4688 4.27357 13.4016 4.74367 13.6502 5.07504C13.8987 5.40641 14.3688 5.47357 14.7002 5.22504L16.2002 4.10004Z" fill="white"/>
                        <path d="M2.80708 9.9464C3.20893 9.84594 3.45325 9.43874 3.35278 9.03689C3.25232 8.63505 2.84512 8.39073 2.44328 8.49119L2.06828 8.58494C1.66643 8.6854 1.42211 9.0926 1.52257 9.49445C1.62303 9.89629 2.03023 10.1406 2.43208 10.0402L2.80708 9.9464Z" fill="white"/>
                        <path d="M15.5571 8.49119C15.1552 8.39073 14.748 8.63505 14.6476 9.03689C14.5471 9.43874 14.7914 9.84594 15.1933 9.9464L15.5683 10.0402C15.9701 10.1406 16.3773 9.89629 16.4778 9.49445C16.5782 9.0926 16.3339 8.6854 15.9321 8.58494L15.5571 8.49119Z" fill="white"/>
                        <path d="M15.0002 14.75V14C15.0002 13.1716 14.3286 12.5 13.5002 12.5H4.50018C3.67175 12.5 3.00018 13.1716 3.00018 14V14.75C3.00018 15.5785 3.67175 16.25 4.50018 16.25H13.5002C14.3286 16.25 15.0002 15.5785 15.0002 14.75Z" fill="white"/>
                        <path opacity="0.5" d="M4.73408 11C4.61413 11 4.52503 10.8889 4.55105 10.7718L5.73932 5.4246C5.89183 4.7383 6.50055 4.25 7.2036 4.25H10.7971C11.5001 4.25 12.1089 4.7383 12.2614 5.4246L13.4496 10.7718C13.4757 10.8889 13.3866 11 13.2666 11H7.75238C7.63243 11 7.54332 10.8889 7.56934 10.7718L8.41998 6.94395C8.50984 6.5396 8.25489 6.13897 7.85054 6.04911C7.44619 5.95925 7.04556 6.2142 6.9557 6.61855L6.0473 10.7063C6.00918 10.8779 5.857 11 5.68123 11H4.73408Z" fill="white"/>
                    </svg>
                    <div class="text-right text-white text-xs font-normal uppercase">annonce importante</div>
                </div>
            </div>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-[#013565] shadow mt-10 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-white">&copy; {{ date('Y') }} France Info Énergie. Tous droits réservés.</p>
                </div>
                <div>
                    <a href="#" class="text-white hover:text-gray-200">Mentions légales</a>
                    <span class="mx-2 text-gray-300">|</span>
                    <a href="#" class="text-white hover:text-gray-200">Politique de confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
