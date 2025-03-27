<x-app-layout>
    <!-- Wrapper principal sans padding horizontal pour permettre aux éléments de prendre la pleine largeur -->
    <div class="w-full">

        <!-- Contenu avec espacement uniforme -->
        <div class="landing-content">
            <!-- Hero Section -->
            @include('partials.landing.hero', ['landing' => $landing])

            <!-- Eligibility Criteria -->
            @include('partials.landing.eligibility', ['landing' => $landing])

            <!-- Comment ça marche Section -->
            @include('partials.landing.how-it-works', ['landing' => $landing])

            <!-- Subsidies Information -->
            @include('partials.landing.subsidies', ['landing' => $landing])

            <!-- Cost Selector -->
            @include('partials.landing.costs', ['landing' => $landing])

            <!-- Call to Action -->
            @include('partials.landing.cta', ['landing' => $landing])

            <!-- Form Section -->
            @include('partials.landing.form', ['landing' => $landing])

            <!-- Opportunity Section -->
            @include('partials.landing.opportunity', ['landing' => $landing])

            <!-- Innovation Section -->
            @include('partials.landing.innovation', ['landing' => $landing])

            <!-- Providers -->
            @include('partials.landing.providers', ['landing' => $landing])

            <!-- Benefits Section -->
            @include('partials.landing.benefits', ['landing' => $landing])

            <!-- Steps Section -->
            @include('partials.landing.steps', ['landing' => $landing])

            <!-- Map Section -->
            @include('partials.landing.map', ['landing' => $landing])
        </div>

        <!-- Footer -->
        @include('partials.landing.footer', ['landing' => $landing])
    </div>

    <!-- Style global pour uniformiser les composants -->
    <style>
        /* Ajout d'une classe pour faciliter les modifications globales */
        .landing-section {
            @apply w-screen relative left-1/2 right-1/2 -mx-[50vw];
        }

        /* Conteneur intérieur standard pour tous les composants */
        .landing-container {
            @apply max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12;
        }

        /* Alignement à gauche pour tous les textes */
        .landing-container h1,
        .landing-container h2,
        .landing-container p {
            @apply text-left;
        }

        /* Couleurs personnalisées */
        :root {
            --primary-color: {{ $landing->getValueOrDefault('primary_color', '#4CAF50') }};
            --secondary-color: {{ $landing->getValueOrDefault('secondary_color', '#2196F3') }};
            --cta-color: {{ $landing->getValueOrDefault('cta_color', '#41b99f') }};
            --blue-color: {{ $landing->getValueOrDefault('blue_color', '#013565') }};
        }

        /* CSS personnalisé */
        @if($landing->isCustomized('custom_css'))
        {!! $landing->custom_css !!}
        @endif
    </style>

    <!-- JS personnalisé -->
    @if($landing->isCustomized('custom_js'))
    <script>
        {!! $landing->custom_js !!}
    </script>
    @endif
</x-app-layout>
