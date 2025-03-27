<div class="w-screen relative left-1/2 right-1/2 -mx-[50vw] bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Titre aligné à gauche -->
        <h2 class="text-black text-xl md:text-2xl lg:text-3xl font-bold font-marianne mb-6">
            {{ $landing->getValueOrDefault('subsidies_title', 'Les aides financières à votre disposition') }}
        </h2>

        <!-- Sous-titre -->
        <p class="text-gray-700 text-lg mb-8">
            {{ $landing->getValueOrDefault('subsidies_subtitle', 'De nombreuses aides sont disponibles pour faciliter votre passage à l\'énergie solaire. Découvrez les principales subventions auxquelles vous pourriez être éligible.') }}
        </p>

        <!-- Grille des subventions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Subvention 1 -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="h-16 w-16 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">{{ $landing->getValueOrDefault('subsidy1_title', 'Prime à l\'autoconsommation') }}</h3>
                <p class="text-gray-600 mb-3">{{ $landing->getValueOrDefault('subsidy1_text', 'Aide versée par l\'État qui permet de réduire le coût d\'installation initial. Son montant varie selon la puissance installée.') }}</p>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <p class="font-semibold text-blue-800">{{ $landing->getValueOrDefault('subsidy1_amount', 'Jusqu\'à 380€ par kWc') }}</p>
                </div>
            </div>

            <!-- Subvention 2 -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="h-16 w-16 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">{{ $landing->getValueOrDefault('subsidy2_title', 'MaPrimeRénov\'') }}</h3>
                <p class="text-gray-600 mb-3">{{ $landing->getValueOrDefault('subsidy2_text', 'Aide financière destinée aux travaux de rénovation énergétique, dont l\'installation de panneaux solaires. Le montant dépend de vos revenus.') }}</p>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <p class="font-semibold text-blue-800">{{ $landing->getValueOrDefault('subsidy2_amount', 'Jusqu\'à 4 000€') }}</p>
                </div>
            </div>

            <!-- Subvention 3 -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="h-16 w-16 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">{{ $landing->getValueOrDefault('subsidy3_title', 'TVA réduite') }}</h3>
                <p class="text-gray-600 mb-3">{{ $landing->getValueOrDefault('subsidy3_text', 'Pour l\'installation de panneaux solaires sur une résidence principale ou secondaire achevée depuis plus de 2 ans.') }}</p>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <p class="font-semibold text-blue-800">{{ $landing->getValueOrDefault('subsidy3_amount', 'TVA à 10% au lieu de 20%') }}</p>
                </div>
            </div>
        </div>

        <!-- Appel à l'action -->
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h3 class="text-xl font-bold mb-3">{{ $landing->getValueOrDefault('subsidies_cta_title', 'Vérifiez votre éligibilité aux aides') }}</h3>
            <p class="text-gray-600 mb-4">{{ $landing->getValueOrDefault('subsidies_cta_text', 'Chaque situation est unique. Nos experts peuvent vous aider à déterminer précisément les aides auxquelles vous avez droit.') }}</p>
            <a href="{{ $landing->getValueOrDefault('subsidies_cta_url', '#form') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all">
                {{ $landing->getValueOrDefault('subsidies_cta_button', 'Estimer mes aides') }}
            </a>
        </div>
    </div>
</div>
