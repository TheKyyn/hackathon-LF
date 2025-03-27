<!-- Section Formulaire -->
<div id="form-section" class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Colonne de gauche avec texte et garanties -->
            <div class="lg:w-1/2">
                <h2 class="text-3xl md:text-4xl font-bold font-marianne mb-6">
                    {{ $landing->getValueOrDefault('form_title', 'Demandez votre étude personnalisée gratuite') }}
                </h2>

                <p class="text-gray-700 mb-8 font-marianne">
                    {{ $landing->getValueOrDefault('form_text', 'Remplissez le formulaire ci-contre pour être contacté par un expert et connaître votre éligibilité aux aides de l\'État pour l\'installation de panneaux solaires.') }}
                </p>

                <div class="space-y-6">
                    <!-- Garanties -->
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold font-marianne">{{ $landing->getValueOrDefault('guarantee1_title', 'Service 100% gratuit') }}</h3>
                            <p class="text-gray-600 font-marianne">{{ $landing->getValueOrDefault('guarantee1_text', 'Notre service d\'accompagnement est entièrement gratuit et sans engagement.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold font-marianne">{{ $landing->getValueOrDefault('guarantee2_title', 'Experts certifiés') }}</h3>
                            <p class="text-gray-600 font-marianne">{{ $landing->getValueOrDefault('guarantee2_text', 'Nos experts sont certifiés et qualifiés pour vous conseiller sur les panneaux solaires.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold font-marianne">{{ $landing->getValueOrDefault('guarantee3_title', 'Installateurs agréés') }}</h3>
                            <p class="text-gray-600 font-marianne">{{ $landing->getValueOrDefault('guarantee3_text', 'Nos partenaires installateurs sont tous certifiés RGE (Reconnu Garant de l\'Environnement).') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne de droite avec le formulaire -->
            <div class="lg:w-1/2 bg-white p-8 rounded-lg shadow-md">
                @livewire('multi-step-form', ['landing' => $landing])
            </div>
        </div>
    </div>
</div>
