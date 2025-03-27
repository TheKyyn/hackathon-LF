<x-app-layout>
    <!-- Wrapper principal sans padding horizontal pour permettre aux éléments de prendre la pleine largeur -->
    <div class="w-full">

        <!-- Contenu avec espacement uniforme -->
        <div class="landing-content">
            <!-- Hero Section -->
            @include('landing.hero')

            <!-- Eligibility Criteria -->
            @include('landing.eligibility')

            <!-- Subsidies Information -->
            @include('landing.subsidies')

            <!-- Cost Selector -->
            @include('landing.costs')

            <!-- Opportunity Section -->
            @include('landing.opportunity')

            <!-- Innovation Section -->
            @include('landing.innovation')

            <!-- Providers -->
            @include('landing.providers')

            <!-- Benefits Section -->
            @include('landing.benefits')

            <!-- Steps Section -->
            @include('landing.steps')

            <!-- Map Section -->
            @include('landing.map')
        </div>

        <!-- Footer -->
        @include('landing.footer')
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
    </style>
</x-app-layout>
