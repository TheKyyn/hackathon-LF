<div class="w-screen relative left-1/2 right-1/2 -mx-[50vw] bg-white py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Titre aligné à gauche -->
        <h2 class="text-black text-xl md:text-2xl lg:text-3xl font-bold font-marianne mb-10">
            {{ $landing->getValueOrDefault('steps_title', 'Les étapes pour obtenir vos panneaux solaires') }}
        </h2>

        <!-- Grille d'étapes -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Étape 1 -->
            <div class="flex flex-col items-start">
                <div class="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold mb-4">1</div>
                <h3 class="text-lg font-bold mb-2">{{ $landing->getValueOrDefault('step1_title', 'Remplissez le formulaire') }}</h3>
                <p class="text-gray-700">{{ $landing->getValueOrDefault('step1_text', 'Prenez quelques minutes pour remplir notre formulaire en ligne. Notre équipe analysera votre situation pour déterminer votre éligibilité.') }}</p>
            </div>

            <!-- Étape 2 -->
            <div class="flex flex-col items-start">
                <div class="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold mb-4">2</div>
                <h3 class="text-lg font-bold mb-2">{{ $landing->getValueOrDefault('step2_title', 'Échangez avec un expert') }}</h3>
                <p class="text-gray-700">{{ $landing->getValueOrDefault('step2_text', 'Un expert vous contactera pour discuter de votre projet et vous présenter les solutions adaptées à votre situation.') }}</p>
            </div>

            <!-- Étape 3 -->
            <div class="flex flex-col items-start">
                <div class="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold mb-4">3</div>
                <h3 class="text-lg font-bold mb-2">{{ $landing->getValueOrDefault('step3_title', 'Recevez votre étude gratuite') }}</h3>
                <p class="text-gray-700">{{ $landing->getValueOrDefault('step3_text', 'Nous vous remettons une étude personnalisée détaillant les économies potentielles et les aides disponibles pour votre projet.') }}</p>
            </div>
        </div>
    </div>
</div>
