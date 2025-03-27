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

        /* CSS personnalisé */
        {!! $landing->custom_css !!}
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
                <h1 class="text-4xl font-bold mb-4">{{ $landing->header_title ?? $landing->title }}</h1>
                <p class="text-xl text-gray-700 mb-8">{{ $landing->header_subtitle ?? $landing->subtitle }}</p>
                <a href="{{ $landing->header_cta_url ?? route('form') }}" class="btn-primary">
                    {{ $landing->header_cta_text }}
                </a>
            </div>
        </section>

        <!-- Content Section -->
        <section class="py-12">
            <div class="container mx-auto px-4">
                <div class="bg-white rounded-lg shadow-lg p-8 max-w-4xl mx-auto">
                    <div class="prose max-w-none">
                        {!! $landing->content !!}
                    </div>

                    <!-- Sections additionnelles -->
                    @if($landing->section1_title)
                    <div class="mt-10">
                        <h2 class="text-2xl font-bold mb-4">{{ $landing->section1_title }}</h2>
                        <div class="prose max-w-none">
                            {!! $landing->section1_content !!}
                        </div>
                    </div>
                    @endif

                    @if($landing->section2_title)
                    <div class="mt-10">
                        <h2 class="text-2xl font-bold mb-4">{{ $landing->section2_title }}</h2>
                        <div class="prose max-w-none">
                            {!! $landing->section2_content !!}
                        </div>
                    </div>
                    @endif

                    @if($landing->section3_title)
                    <div class="mt-10">
                        <h2 class="text-2xl font-bold mb-4">{{ $landing->section3_title }}</h2>
                        <div class="prose max-w-none">
                            {!! $landing->section3_content !!}
                        </div>
                    </div>
                    @endif

                    @if($landing->advantages_title)
                    <div class="mt-10">
                        <h3 class="text-xl font-semibold mb-4">{{ $landing->advantages_title }}</h3>
                        <div class="prose max-w-none">
                            {!! $landing->advantages_list !!}
                        </div>
                    </div>
                    @endif

                    <!-- Section témoignages -->
                    @if($landing->testimonials && count((array)$landing->testimonials) > 0)
                    <div class="mt-16">
                        <h2 class="text-2xl font-bold mb-8 text-center">Témoignages clients</h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            @foreach((array)$landing->testimonials as $name => $testimonial)
                            <div class="bg-gray-50 p-6 rounded-lg shadow">
                                <p class="italic mb-4">"{{ $testimonial }}"</p>
                                <div class="font-semibold text-primary">{{ $name }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Section FAQ -->
                    @if($landing->faq_title && $landing->faq_content)
                    <div class="mt-16">
                        <h2 class="text-2xl font-bold mb-6 text-center">{{ $landing->faq_title }}</h2>
                        <div class="prose max-w-none">
                            {!! $landing->faq_content !!}
                        </div>
                    </div>
                    @endif

                    <div class="mt-12 text-center">
                        <a href="{{ route('form') }}" class="btn-primary">
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
                <p>{{ $landing->footer_text }}</p>

                @if($landing->footer_links && count((array)$landing->footer_links) > 0)
                <div class="mt-4 flex justify-center gap-4">
                    @foreach((array)$landing->footer_links as $text => $url)
                    <a href="{{ $url }}" class="text-gray-300 hover:text-white">{{ $text }}</a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </footer>

    <!-- JavaScript personnalisé -->
    @if($landing->custom_js)
    <script>
        {!! $landing->custom_js !!}
    </script>
    @endif
</body>
</html>
