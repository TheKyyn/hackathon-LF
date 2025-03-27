<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landing->title }}</title>
    <meta name="description" content="{{ $landing->meta_description }}">
    <meta name="keywords" content="{{ $landing->meta_keywords }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $landing->og_title ?? $landing->title }}">
    <meta property="og:description" content="{{ $landing->og_description ?? $landing->meta_description }}">
    @if($landing->og_image)
    <meta property="og:image" content="{{ asset('storage/' . $landing->og_image) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $landing->og_title ?? $landing->title }}">
    <meta property="twitter:description" content="{{ $landing->og_description ?? $landing->meta_description }}">
    @if($landing->og_image)
    <meta property="twitter:image" content="{{ asset('storage/' . $landing->og_image) }}">
    @endif

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: {{ $landing->primary_color }};
            --secondary-color: {{ $landing->secondary_color }};
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }
        .bg-primary {
            background-color: var(--primary-color);
        }
        .text-primary {
            color: var(--primary-color);
        }
        .bg-secondary {
            background-color: var(--secondary-color);
        }
        .text-secondary {
            color: var(--secondary-color);
        }
        .btn-primary {
            background-color: {{ $landing->cta_color }};
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        .banner {
            background-image: url('{{ $landing->background_image ? asset("storage/" . $landing->background_image) : "" }}');
            background-size: cover;
            background-position: center;
        }
        @if(!$landing->background_image)
        .banner {
            background-color: #f3f4f6;
        }
        @endif
    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            @if($landing->logo)
            <img src="{{ asset('storage/' . $landing->logo) }}" alt="Logo" class="h-10">
            @else
            <h1 class="text-xl font-bold text-primary">Panneaux Solaires & Pompes à Chaleur</h1>
            @endif
            <div>
                <a href="#" class="text-gray-600 hover:text-primary">Accueil</a>
            </div>
        </div>
    </header>

    <main>
        <!-- Banner Section -->
        <section class="banner py-16">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-4xl font-bold mb-4">{{ $landing->title }}</h1>
                @if($landing->subtitle)
                <p class="text-xl text-gray-700 mb-8">{{ $landing->subtitle }}</p>
                @endif
            </div>
        </section>

        <!-- Content Section -->
        <section class="py-12">
            <div class="container mx-auto px-4">
                <div class="bg-white rounded-lg shadow-lg p-8 max-w-4xl mx-auto">
                    <div class="prose max-w-none">
                        {!! $landing->content !!}
                    </div>

                    @if($landing->advantages_title)
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold mb-4">{{ $landing->advantages_title }}</h3>
                        <div class="prose max-w-none">
                            {!! $landing->advantages_list !!}
                        </div>
                    </div>
                    @endif

                    <div class="mt-10 text-center">
                        <a href="{{ route('home') }}" class="btn-primary">
                            {{ $landing->cta_text }}
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} - Panneau Solaire et Pompe à Chaleur</p>
            </div>
        </div>
    </footer>
</body>
</html>
