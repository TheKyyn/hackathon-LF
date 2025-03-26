<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6 text-center">Obtenez un devis gratuit pour votre projet d'énergie renouvelable</h2>

                    <div class="mb-8 max-w-2xl mx-auto">
                        <p class="text-gray-600 mb-4">
                            Que vous soyez intéressé par des panneaux photovoltaïques ou une pompe à chaleur, notre formulaire simple vous permettra d'obtenir un devis personnalisé en quelques minutes.
                        </p>
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Remplissez notre formulaire et obtenez un rendez-vous avec un expert qui vous aidera à choisir la meilleure solution pour votre logement.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire multi-étapes -->
                    <livewire:multi-step-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
