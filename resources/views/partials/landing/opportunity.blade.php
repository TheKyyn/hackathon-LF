<div class="w-screen relative left-1/2 right-1/2 -mx-[50vw] bg-blue-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Titre aligné à gauche -->
        <h2 class="text-black text-xl md:text-2xl lg:text-3xl font-bold font-marianne mb-6">
            {{ $landing->getValueOrDefault('opportunity_title', 'Une opportunité unique pour les propriétaires') }}
        </h2>

        <!-- Texte d'introduction -->
        <p class="text-gray-700 text-base md:text-lg mb-8">
            {{ $landing->getValueOrDefault('opportunity_intro', 'Le contexte actuel représente une opportunité sans précédent pour les propriétaires souhaitant réduire leur facture énergétique et agir pour l\'environnement.') }}
        </p>

        <!-- Points clés en grille -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Point 1 -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-start mb-3">
                    <div class="bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3 flex-shrink-0">✓</div>
                    <h3 class="text-lg font-bold">{{ $landing->getValueOrDefault('opportunity_point1_title', 'Aides gouvernementales exceptionnelles') }}</h3>
                </div>
                <p class="text-gray-600 ml-11">{{ $landing->getValueOrDefault('opportunity_point1_text', 'Le gouvernement a mis en place des subventions couvrant jusqu\'à 90% du coût d\'installation pour certains foyers.') }}</p>
            </div>

            <!-- Point 2 -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-start mb-3">
                    <div class="bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3 flex-shrink-0">✓</div>
                    <h3 class="text-lg font-bold">{{ $landing->getValueOrDefault('opportunity_point2_title', 'Hausse des prix de l\'énergie') }}</h3>
                </div>
                <p class="text-gray-600 ml-11">{{ $landing->getValueOrDefault('opportunity_point2_text', 'Face à l\'augmentation continue des prix de l\'électricité, l\'autoconsommation devient une solution économique avantageuse.') }}</p>
            </div>

            <!-- Point 3 -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-start mb-3">
                    <div class="bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3 flex-shrink-0">✓</div>
                    <h3 class="text-lg font-bold">{{ $landing->getValueOrDefault('opportunity_point3_title', 'Valorisation immobilière') }}</h3>
                </div>
                <p class="text-gray-600 ml-11">{{ $landing->getValueOrDefault('opportunity_point3_text', 'Les maisons équipées de panneaux solaires se vendent plus rapidement et à un prix supérieur sur le marché immobilier.') }}</p>
            </div>

            <!-- Point 4 -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-start mb-3">
                    <div class="bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3 flex-shrink-0">✓</div>
                    <h3 class="text-lg font-bold">{{ $landing->getValueOrDefault('opportunity_point4_title', 'Engagement écologique') }}</h3>
                </div>
                <p class="text-gray-600 ml-11">{{ $landing->getValueOrDefault('opportunity_point4_text', 'Réduisez votre empreinte carbone tout en contribuant à la transition énergétique nationale.') }}</p>
            </div>
        </div>

        <!-- Appel à l'action -->
        <div class="text-center mt-8">
            <a href="{{ $landing->getValueOrDefault('opportunity_cta_url', '#form') }}"
               class="inline-block px-8 py-4 bg-blue-600 text-white font-medium text-lg rounded-lg hover:bg-blue-700 transition-all">
                {{ $landing->getValueOrDefault('opportunity_cta_text', 'Profitez de cette opportunité') }}
            </a>
        </div>
    </div>
</div>
