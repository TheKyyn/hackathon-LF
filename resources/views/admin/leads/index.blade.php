<x-app-layout>
    <div class="py-8 bg-dark-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-heading font-bold text-dark-900">Gestion des leads</h1>
                    <p class="mt-2 text-dark-600">Gérez et qualifiez vos prospects depuis cette interface.</p>
                </div>
                <div class="flex space-x-3">
                    <x-button variant="light" icon="filter">
                        Filtrer
                    </x-button>
                    <x-button variant="light" icon="export">
                        Exporter
                    </x-button>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 flex p-4 bg-success-50 border-l-4 border-success-500 rounded-lg">
                    <svg class="w-6 h-6 text-success-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-success-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                <div class="p-1">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-dark-100">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-dark-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-dark-500 uppercase tracking-wider">Nom</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-dark-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-dark-500 uppercase tracking-wider">Téléphone</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-dark-500 uppercase tracking-wider">Installation</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-dark-500 uppercase tracking-wider">Logement</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-dark-500 uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-dark-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-dark-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-dark-100">
                                @foreach ($leads as $lead)
                                    <tr class="hover:bg-dark-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-dark-900">{{ $lead->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-dark-800">
                                            <div class="font-medium">{{ $lead->full_name }}</div>
                                            <div class="text-dark-500 text-xs">{{ $lead->postal_code ?? $lead->department }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-dark-800">{{ $lead->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-dark-800">{{ $lead->phone }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($lead->installation_type == 'solaire')
                                                <x-badge type="secondary" icon="solar">
                                                    Solaire
                                                </x-badge>
                                            @elseif($lead->installation_type == 'photovoltaique')
                                                <x-badge type="secondary" icon="photovoltaic">
                                                    Photovoltaïque
                                                </x-badge>
                                            @elseif($lead->installation_type == 'chauffe_eau')
                                                <x-badge type="primary" icon="water-heater">
                                                    Chauffe-eau
                                                </x-badge>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($lead->property_type == 'maison')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                    </svg>
                                                    Maison
                                                </span>
                                            @elseif(in_array($lead->property_type, ['studio', 't2', 't3_plus']))
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                    </svg>
                                                    {{ ucfirst(str_replace('_', ' ', $lead->property_type)) }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-dark-100 text-dark-800">
                                                    Autre
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($lead->status == 'new')
                                                <x-badge type="primary">Nouveau</x-badge>
                                            @elseif($lead->status == 'contacted')
                                                <x-badge type="secondary">Contacté</x-badge>
                                            @elseif($lead->status == 'qualified')
                                                <x-badge type="success">Qualifié</x-badge>
                                            @elseif($lead->status == 'not_qualified')
                                                <x-badge type="danger">Non qualifié</x-badge>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-dark-800">
                                            <div>{{ $lead->created_at->format('d/m/Y') }}</div>
                                            <div class="text-dark-500 text-xs">{{ $lead->created_at->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('admin.leads.show', $lead) }}" class="text-primary-600 hover:text-primary-800 p-2 rounded-full hover:bg-primary-50 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('admin.leads.edit', $lead) }}" class="text-secondary-600 hover:text-secondary-800 p-2 rounded-full hover:bg-secondary-50 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 bg-dark-50 border-t border-dark-100">
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-dark-600">Affichage de <span class="font-medium">{{ count($leads) }}</span> leads</p>
                            <div class="flex space-x-1">
                                <a href="#" class="inline-flex items-center px-4 py-2 border border-dark-200 rounded-md text-sm font-medium text-dark-700 bg-white hover:bg-dark-50">
                                    Précédent
                                </a>
                                <a href="#" class="inline-flex items-center px-4 py-2 border border-dark-200 rounded-md text-sm font-medium text-dark-700 bg-white hover:bg-dark-50">
                                    Suivant
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
