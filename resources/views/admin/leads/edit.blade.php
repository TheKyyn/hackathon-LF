<x-app-layout>
    <div class="py-8 bg-dark-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- En-tête -->
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-heading font-bold text-dark-900">Modifier le lead #{{ $lead->id }}</h1>
                    <p class="mt-2 text-dark-600">Mettez à jour le statut et ajoutez des commentaires à ce lead.</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.leads.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-dark-200 rounded-lg text-dark-700 hover:bg-dark-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Retour à la liste
                    </a>
                    <a href="{{ route('admin.leads.show', $lead) }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Voir détails
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 flex p-4 bg-success-50 border-l-4 border-success-500 rounded-lg">
                    <svg class="w-6 h-6 text-success-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-success-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Formulaire d'édition -->
                <div class="lg:col-span-2">
                    <form action="{{ route('admin.leads.update', $lead) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="px-6 py-4 bg-primary-50 border-b border-primary-100">
                                <h3 class="text-lg font-heading font-semibold text-primary-800">Statut et suivi</h3>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-dark-700 mb-2">Statut</label>
                                    <select id="status" name="status" class="form-input bg-white">
                                        <option value="new" {{ $lead->status === 'new' ? 'selected' : '' }}>Nouveau</option>
                                        <option value="contacted" {{ $lead->status === 'contacted' ? 'selected' : '' }}>Contacté</option>
                                        <option value="qualified" {{ $lead->status === 'qualified' ? 'selected' : '' }}>Qualifié</option>
                                        <option value="not_qualified" {{ $lead->status === 'not_qualified' ? 'selected' : '' }}>Non qualifié</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger-600 mt-1 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="sale_status" class="block text-sm font-medium text-dark-700 mb-2">Statut de vente</label>
                                    <select id="sale_status" name="sale_status" class="form-input bg-white">
                                        <option value="" {{ $lead->sale_status === null ? 'selected' : '' }}>Non défini</option>
                                        <option value="to_sell" {{ $lead->sale_status === 'to_sell' ? 'selected' : '' }}>À vendre</option>
                                        <option value="sold" {{ $lead->sale_status === 'sold' ? 'selected' : '' }}>Vendu</option>
                                        <option value="canceled" {{ $lead->sale_status === 'canceled' ? 'selected' : '' }}>Annulé</option>
                                    </select>
                                    @error('sale_status')
                                        <div class="text-danger-600 mt-1 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="comment" class="block text-sm font-medium text-dark-700 mb-2">Commentaire</label>
                                    <textarea id="comment" name="comment" rows="6" class="form-input w-full">{{ $lead->comment }}</textarea>
                                    @error('comment')
                                        <div class="text-danger-600 mt-1 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 shadow-sm transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Enregistrer les modifications
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Informations du lead -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-secondary-50 border-b border-secondary-100">
                        <h3 class="text-lg font-heading font-semibold text-secondary-800">Informations du lead</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-dark-500">Nom complet</p>
                                <p class="text-dark-900 font-medium">{{ $lead->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Email</p>
                                <p class="text-dark-900 font-medium">{{ $lead->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Téléphone</p>
                                <p class="text-dark-900 font-medium">{{ $lead->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Facture d'énergie</p>
                                <p class="text-dark-900 font-medium">
                                    @if($lead->energy_bill == 'less_100')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">Moins de 100€</span>
                                    @elseif($lead->energy_bill == '100_200')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">Entre 100€ et 200€</span>
                                    @elseif($lead->energy_bill == '200_300')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-100 text-secondary-800">Entre 200€ et 300€</span>
                                    @elseif($lead->energy_bill == 'more_300')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger-100 text-danger-800">Plus de 300€</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Type d'installation</p>
                                <p class="text-dark-900 font-medium">
                                    @if($lead->installation_type == 'solaire')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-100 text-secondary-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                            Solaire
                                        </span>
                                    @elseif($lead->installation_type == 'photovoltaique')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-100 text-secondary-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            Photovoltaïque
                                        </span>
                                    @elseif($lead->installation_type == 'chauffe_eau')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                            </svg>
                                            Chauffe-eau
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Qualification</p>
                                <p class="text-dark-900 font-medium">
                                    @if($lead->isQualified())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">Qualifié</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger-100 text-danger-800">Non qualifié</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-dark-100">
                            <a href="{{ route('admin.leads.show', $lead) }}" class="inline-flex items-center text-primary-600 hover:text-primary-800">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Voir toutes les informations
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
