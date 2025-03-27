<div class="w-screen relative left-1/2 right-1/2 -mx-[50vw] bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Titre aligné à gauche -->
        <h2 class="text-black text-xl md:text-2xl lg:text-3xl font-bold font-marianne mb-6">
            {{ $landing->getValueOrDefault('innovation_title', 'L\'innovation au service de votre économie d\'énergie') }}
        </h2>

        <!-- Contenu avec image à droite et texte à gauche -->
        <div class="flex flex-col md:flex-row items-center gap-8">
            <!-- Texte à gauche -->
            <div class="w-full md:w-1/2 order-2 md:order-1">
                <p class="text-gray-700 text-base md:text-lg mb-4">
                    {{ $landing->getValueOrDefault('innovation_text1', 'Les panneaux solaires de dernière génération offrent un rendement énergétique inégalé. Grâce aux avancées technologiques et à la baisse des coûts de production, l\'énergie solaire est désormais accessible à tous les foyers français.') }}
                </p>
                <p class="text-gray-700 text-base md:text-lg mb-4">
                    {{ $landing->getValueOrDefault('innovation_text2', 'Nos solutions intégrées comprennent des systèmes de stockage d\'énergie pour vous permettre de profiter de votre production même la nuit ou lors des journées peu ensoleillées.') }}
                </p>
                <div class="mt-6">
                    <a href="{{ $landing->getValueOrDefault('innovation_button_url', '#form') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-medium rounded-lg transition-colors hover:bg-blue-700">
                        {{ $landing->getValueOrDefault('innovation_button_text', 'En savoir plus') }}
                    </a>
                </div>
            </div>

            <!-- Image à droite -->
            <div class="w-full md:w-1/2 order-1 md:order-2">
                <img src="{{ asset('storage/' . $landing->getValueOrDefault('innovation_image', 'landing-pages/innovation.jpg')) }}"
                     alt="Innovation solaire"
                     class="w-full h-auto rounded-lg shadow-md"
                     onerror="this.src='https://placehold.co/600x400/e2f1ff/1565c0?text=Innovation+Solaire';this.onerror='';">
            </div>
        </div>
    </div>
</div>
