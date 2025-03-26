<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6 text-center">Prenez rendez-vous avec un expert</h2>

                    <div class="mb-8 max-w-2xl mx-auto">
                        <p class="text-gray-600 mb-4">
                            Merci pour vos informations, {{ $lead->first_name }}. Veuillez maintenant choisir un créneau qui vous convient pour discuter avec un de nos experts.
                        </p>
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">
                                        Votre demande a été enregistrée avec succès. Choisissez maintenant un créneau pour votre rendez-vous.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Intégration Calendly -->
                    <div class="calendly-inline-widget" data-url="{{ $calendlyUrl }}?hide_gdpr_banner=1&name={{ urlencode($lead->full_name) }}&email={{ urlencode($lead->email) }}&a1={{ urlencode($lead->phone) }}" style="min-width:320px;height:700px;"></div>
                    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
                    <script type="text/javascript">
                        window.addEventListener('DOMContentLoaded', function() {
                            // Configuration de Calendly avec l'API key
                            Calendly.initInlineWidget({
                                url: '{{ $calendlyUrl }}?hide_gdpr_banner=1',
                                parentElement: document.querySelector('.calendly-inline-widget'),
                                prefill: {
                                    name: "{{ $lead->first_name }} {{ $lead->last_name }}",
                                    email: "{{ $lead->email }}",
                                    customAnswers: {
                                        a1: "{{ $lead->phone }}"
                                    }
                                }
                            });

                            // Ajout de l'authentification avec la clé API depuis les variables d'environnement
                            Calendly.token = "{{ env('CALENDLY_API_KEY') }}";
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
