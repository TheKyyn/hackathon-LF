<x-app-layout>
    <div class="py-8 bg-dark-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- En-tête -->
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-heading font-bold text-dark-900">Détails du lead #{{ $lead->id }}</h1>
                    <p class="mt-2 text-dark-600">Informations complètes sur le lead et son projet.</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.leads.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-dark-200 rounded-lg text-dark-700 hover:bg-dark-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Retour à la liste
                    </a>
                    <a href="{{ route('admin.leads.edit', $lead) }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Modifier
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

            <!-- Statut rapide -->
            <div class="flex flex-wrap gap-4 mb-8">
                <div class="flex items-center bg-white px-4 py-3 rounded-xl shadow-sm">
                    <span class="w-3 h-3 rounded-full mr-2
                        @if($lead->status == 'new') bg-primary-500
                        @elseif($lead->status == 'contacted') bg-secondary-500
                        @elseif($lead->status == 'qualified') bg-success-500
                        @elseif($lead->status == 'not_qualified') bg-danger-500
                        @endif"></span>
                    <span class="font-medium text-dark-900">
                        @if($lead->status == 'new') Nouveau
                        @elseif($lead->status == 'contacted') Contacté
                        @elseif($lead->status == 'qualified') Qualifié
                        @elseif($lead->status == 'not_qualified') Non qualifié
                        @endif
                    </span>
                </div>
                <div class="flex items-center bg-white px-4 py-3 rounded-xl shadow-sm">
                    <span class="mr-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </span>
                    <span class="font-medium text-dark-900">{{ $lead->created_at->format('d/m/Y') }}</span>
                </div>
                @if($lead->appointment_date)
                <div class="flex items-center bg-white px-4 py-3 rounded-xl shadow-sm">
                    <span class="mr-2">
                        <svg class="w-5 h-5 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </span>
                    <span class="font-medium text-dark-900">RDV: {{ $lead->appointment_date->format('d/m/Y à H:i') }}</span>
                </div>
                @endif
                <div class="flex items-center bg-white px-4 py-3 rounded-xl shadow-sm">
                    <span class="mr-2">
                        <svg class="w-5 h-5 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </span>
                    <span class="font-medium text-dark-900">
                        @if($lead->property_type == 'maison') Maison
                        @elseif($lead->property_type == 'studio') Studio
                        @elseif($lead->property_type == 't2') T2
                        @elseif($lead->property_type == 't3_plus') T3+
                        @elseif($lead->property_type == 'autre') Autre
                        @endif
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Informations personnelles -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-primary-50 border-b border-primary-100">
                        <h3 class="text-lg font-heading font-semibold text-primary-800">Informations personnelles</h3>
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
                                <p class="text-sm text-dark-500">Date de naissance</p>
                                <p class="text-dark-900 font-medium">{{ $lead->birth_date ? $lead->birth_date->format('d/m/Y') : 'Non renseignée' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Optin</p>
                                <p class="text-dark-900 font-medium">
                                    @if($lead->optin)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">Accepté</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-dark-100 text-dark-800">Refusé</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Localisation -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-secondary-50 border-b border-secondary-100">
                        <h3 class="text-lg font-heading font-semibold text-secondary-800">Localisation</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @if($lead->location_type == 'code_postal')
                                <div>
                                    <p class="text-sm text-dark-500">Code postal</p>
                                    <p class="text-dark-900 font-medium">{{ $lead->postal_code }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-dark-500">Ville</p>
                                    <p class="text-dark-900 font-medium">{{ $lead->city ?: 'Non renseignée' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-dark-500">Adresse</p>
                                    <p class="text-dark-900 font-medium">{{ $lead->address ?: 'Non renseignée' }}</p>
                                </div>
                            @else
                                <div>
                                    <p class="text-sm text-dark-500">Département</p>
                                    <p class="text-dark-900 font-medium">{{ $lead->department }}</p>
                                </div>
                            @endif
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
                        </div>
                    </div>
                </div>

                <!-- Statut et suivi -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-success-50 border-b border-success-100">
                        <h3 class="text-lg font-heading font-semibold text-success-800">Statut et suivi</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-dark-500">Statut</p>
                                <p class="mt-1">
                                    @if($lead->status == 'new')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">Nouveau</span>
                                    @elseif($lead->status == 'contacted')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-100 text-secondary-800">Contacté</span>
                                    @elseif($lead->status == 'qualified')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">Qualifié</span>
                                    @elseif($lead->status == 'not_qualified')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger-100 text-danger-800">Non qualifié</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Statut de vente</p>
                                <p class="mt-1">
                                    @if($lead->sale_status == 'to_sell')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-100 text-secondary-800">À vendre</span>
                                    @elseif($lead->sale_status == 'sold')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">Vendu</span>
                                    @elseif($lead->sale_status == 'canceled')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger-100 text-danger-800">Annulé</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-dark-100 text-dark-800">Non défini</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Date de création</p>
                                <p class="text-dark-900 font-medium">{{ $lead->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Dernière mise à jour</p>
                                <p class="text-dark-900 font-medium">{{ $lead->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Détails du logement et du projet -->
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Informations sur le logement -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-dark-50 border-b border-dark-100">
                        <h3 class="text-lg font-heading font-semibold text-dark-800">Informations sur le logement</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-6">
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
                                <p class="text-sm text-dark-500">Propriétaire</p>
                                <p class="text-dark-900 font-medium">
                                    @if($lead->is_owner)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">Oui</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger-100 text-danger-800">Non</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Type de logement</p>
                                <p class="text-dark-900 font-medium">
                                    @if($lead->property_type == 'maison')
                                        Maison
                                    @elseif($lead->property_type == 'studio')
                                        Studio
                                    @elseif($lead->property_type == 't2')
                                        T2
                                    @elseif($lead->property_type == 't3_plus')
                                        T3+
                                    @elseif($lead->property_type == 'autre')
                                        Autre
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Surface habitable</p>
                                <p class="text-dark-900 font-medium">
                                    @if($lead->property_size == 'less_50')
                                        Moins de 50m²
                                    @elseif($lead->property_size == '51_100')
                                        De 51 à 100m²
                                    @elseif($lead->property_size == '101_150')
                                        De 101 à 150m²
                                    @elseif($lead->property_size == '151_200')
                                        De 151 à 200m²
                                    @elseif($lead->property_size == 'more_200')
                                        Plus de 200m²
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Statut du foyer</p>
                                <p class="text-dark-900 font-medium">
                                    @if($lead->household_status == 'cdi')
                                        CDI
                                    @elseif($lead->household_status == 'cdd')
                                        CDD
                                    @elseif($lead->household_status == 'chomage')
                                        Chômage
                                    @elseif($lead->household_status == 'retraite')
                                        Retraité
                                    @elseif($lead->household_status == 'autre')
                                        Autre
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Type de chauffage</p>
                                <p class="text-dark-900 font-medium">
                                    @if($lead->heating_type == 'electrique')
                                        Électrique
                                    @elseif($lead->heating_type == 'gaz')
                                        Gaz
                                    @elseif($lead->heating_type == 'fioul')
                                        Fioul
                                    @elseif($lead->heating_type == 'bois')
                                        Bois
                                    @elseif($lead->heating_type == 'autre')
                                        Autre
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Toiture isolée</p>
                                <p class="text-dark-900 font-medium">
                                    @if($lead->roof_insulated === true)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">Oui</span>
                                    @elseif($lead->roof_insulated === false)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger-100 text-danger-800">Non</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-dark-100 text-dark-800">Ne sait pas</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Matériau toiture</p>
                                <p class="text-dark-900 font-medium">
                                    @if($lead->roof_material == 'tuile')
                                        Tuile
                                    @elseif($lead->roof_material == 'ardoise')
                                        Ardoise
                                    @elseif($lead->roof_material == 'zinc')
                                        Zinc
                                    @elseif($lead->roof_material == 'etancheite')
                                        Étanchéité
                                    @elseif($lead->roof_material == 'autre')
                                        Autre
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations sur le projet -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-dark-50 border-b border-dark-100">
                        <h3 class="text-lg font-heading font-semibold text-dark-800">Informations sur le projet</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-dark-500">Type d'installation</p>
                                <p class="text-dark-900 font-medium">
                                    @if($lead->installation_type == 'solaire')
                                        Solaire
                                    @elseif($lead->installation_type == 'photovoltaique')
                                        Photovoltaïque
                                    @elseif($lead->installation_type == 'chauffe_eau')
                                        Chauffe-eau
                                    @endif
                                </p>
                            </div>

                            @if($lead->panel_size)
                                <div>
                                    <p class="text-sm text-dark-500">Surface de panneaux</p>
                                    <p class="text-dark-900 font-medium">
                                        @if($lead->panel_size == '10m')
                                            10m²
                                        @elseif($lead->panel_size == '20m')
                                            20m²
                                        @elseif($lead->panel_size == '30m')
                                            30m²
                                        @elseif($lead->panel_size == 'dont_know')
                                            Ne sait pas
                                        @endif
                                    </p>
                                </div>
                            @endif

                            @if($lead->pac_type)
                                <div>
                                    <p class="text-sm text-dark-500">Type de PAC</p>
                                    <p class="text-dark-900 font-medium">
                                        @if($lead->pac_type == 'air_eau')
                                            PAC Air/Eau
                                        @elseif($lead->pac_type == 'air_air')
                                            PAC Air/Air
                                        @elseif($lead->pac_type == 'geothermie')
                                            PAC géothermie
                                        @endif
                                    </p>
                                </div>
                            @endif

                            <div>
                                <p class="text-sm text-dark-500">Accepte les aides</p>
                                <p class="text-dark-900 font-medium">
                                    @if($lead->accept_aid)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">Oui</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger-100 text-danger-800">Non</span>
                                    @endif
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-dark-500">Nombre de personnes</p>
                                <p class="text-dark-900 font-medium">
                                    @if($lead->household_count == '1')
                                        1 personne
                                    @elseif($lead->household_count == '2')
                                        2 personnes
                                    @elseif($lead->household_count == '3')
                                        3 personnes
                                    @elseif($lead->household_count == '4_plus')
                                        4 personnes ou plus
                                    @endif
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-dark-500">Revenus annuels</p>
                                <p class="text-dark-900 font-medium">
                                    @if($lead->annual_income == 'less_20k')
                                        Moins de 20k€/an
                                    @elseif($lead->annual_income == '20k_40k')
                                        Entre 20k€ et 40k€/an
                                    @elseif($lead->annual_income == 'more_40k')
                                        Plus de 40k€/an
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Commentaires et Tracking -->
            <div class="mt-6 grid grid-cols-1 gap-6">
                <!-- Commentaire -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-dark-50 border-b border-dark-100">
                        <h3 class="text-lg font-heading font-semibold text-dark-800">Commentaire</h3>
                    </div>
                    <div class="p-6">
                        <div class="prose max-w-none">
                            {{ $lead->comment ?? 'Aucun commentaire' }}
                        </div>
                    </div>
                </div>

                @if($lead->appointment_date)
                <!-- Rendez-vous -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-secondary-50 border-b border-secondary-100">
                        <h3 class="text-lg font-heading font-semibold text-secondary-800">Rendez-vous</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-dark-500">Date du rendez-vous</p>
                                <p class="text-dark-900 font-medium">{{ $lead->appointment_date->format('d/m/Y à H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">ID du rendez-vous</p>
                                <p class="text-dark-900 font-medium">{{ $lead->appointment_id }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Informations de tracking -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-dark-50 border-b border-dark-100">
                        <h3 class="text-lg font-heading font-semibold text-dark-800">Informations de tracking</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div>
                                <p class="text-sm text-dark-500">Adresse IP</p>
                                <p class="text-dark-900 font-medium">{{ $lead->ip_address ?? 'Non disponible' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Source (UTM)</p>
                                <p class="text-dark-900 font-medium">{{ $lead->utm_source ?? 'Non disponible' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Medium (UTM)</p>
                                <p class="text-dark-900 font-medium">{{ $lead->utm_medium ?? 'Non disponible' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-dark-500">Campagne (UTM)</p>
                                <p class="text-dark-900 font-medium">{{ $lead->utm_campaign ?? 'Non disponible' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
