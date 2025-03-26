<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center">
                        <svg class="mx-auto h-24 w-24 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">Rendez-vous confirmé !</h2>
                        <p class="mt-2 text-lg text-gray-600">
                            Merci {{ $lead->first_name }} pour votre prise de rendez-vous.
                        </p>
                    </div>

                    <div class="mt-8 max-w-lg mx-auto">
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <h3 class="text-xl font-semibold mb-4">Récapitulatif de votre demande</h3>

                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500">Nom complet</p>
                                    <p class="font-medium">{{ $lead->full_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Email</p>
                                    <p class="font-medium">{{ $lead->email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Téléphone</p>
                                    <p class="font-medium">{{ $lead->phone }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Type d'énergie</p>
                                    <p class="font-medium">
                                        @if($lead->energy_type == 'pompe_a_chaleur')
                                            Pompe à chaleur
                                        @elseif($lead->energy_type == 'panneaux_photovoltaiques')
                                            Panneaux photovoltaïques
                                        @elseif($lead->energy_type == 'les_deux')
                                            Pompe à chaleur et panneaux photovoltaïques
                                        @endif
                                    </p>
                                </div>
                                @if($lead->appointment_date)
                                <div>
                                    <p class="text-sm text-gray-500">Date de rendez-vous</p>
                                    <p class="font-medium">{{ $lead->appointment_date->format('d/m/Y à H:i') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-8 bg-blue-50 p-6 rounded-lg border border-blue-200">
                            <h3 class="text-xl font-semibold mb-4 text-blue-800">Que se passe-t-il maintenant ?</h3>
                            <ul class="list-disc pl-5 space-y-2 text-blue-700">
                                <li>Vous recevrez un email de confirmation avec les détails de votre rendez-vous.</li>
                                <li>Nous vous enverrons un SMS de rappel 24h avant le rendez-vous.</li>
                                <li>Notre expert vous contactera à l'heure prévue pour discuter de votre projet.</li>
                            </ul>
                        </div>

                        <div class="mt-8 text-center">
                            <a href="{{ route('home') }}" class="form-btn-secondary inline-block">
                                Retour à l'accueil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
