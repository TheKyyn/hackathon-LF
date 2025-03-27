<!-- Section Formulaire -->
<div id="form" class="w-screen relative left-1/2 right-1/2 -mx-[50vw] bg-white py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Titre aligné à gauche -->
        <h2 class="text-black text-xl md:text-2xl lg:text-3xl font-bold font-marianne mb-6">
            {{ $landing->getValueOrDefault('form_title', 'Demandez votre étude personnalisée gratuite') }}
        </h2>

        <!-- Texte d'introduction -->
        <p class="text-gray-700 text-lg mb-8">
            {{ $landing->getValueOrDefault('form_text', 'Complétez le formulaire ci-dessous pour savoir si vous êtes éligible aux aides de l\'État pour l\'installation de panneaux solaires. Un conseiller vous contactera rapidement pour vous présenter les solutions adaptées à votre situation.') }}
        </p>

        <!-- Formulaire et garanties -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Formulaire à gauche -->
            <div class="w-full lg:w-2/3">
                <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                    @livewire('multi-step-form', ['source' => 'landing', 'landing_id' => $landing->id])
                </div>
            </div>

            <!-- Garanties à droite -->
            <div class="w-full lg:w-1/3">
                <div class="bg-blue-50 p-6 rounded-lg h-full">
                    <h3 class="text-xl font-bold mb-6">Nos garanties</h3>

                    <div class="space-y-6">
                        <!-- Garantie 1 -->
                        <div class="flex items-start">
                            <div class="bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center mr-4 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold">{{ $landing->getValueOrDefault('guarantee1_title', 'Service 100% gratuit') }}</h4>
                                <p class="text-gray-600">{{ $landing->getValueOrDefault('guarantee1_text', 'Notre service d\'étude et de conseil est entièrement gratuit et sans engagement.') }}</p>
                            </div>
                        </div>

                        <!-- Garantie 2 -->
                        <div class="flex items-start">
                            <div class="bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center mr-4 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold">{{ $landing->getValueOrDefault('guarantee2_title', 'Experts certifiés') }}</h4>
                                <p class="text-gray-600">{{ $landing->getValueOrDefault('guarantee2_text', 'Nos conseillers sont formés et certifiés pour vous proposer les meilleures solutions.') }}</p>
                            </div>
                        </div>

                        <!-- Garantie 3 -->
                        <div class="flex items-start">
                            <div class="bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center mr-4 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold">{{ $landing->getValueOrDefault('guarantee3_title', 'Installateurs agréés') }}</h4>
                                <p class="text-gray-600">{{ $landing->getValueOrDefault('guarantee3_text', 'Nous travaillons uniquement avec des installateurs agréés qui respectent les normes de qualité.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
