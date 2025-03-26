<div>
    <div class="max-w-3xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-[#41b99f]/20 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#41b99f]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-[#013565] mb-2">Félicitations !</h2>
                    <p class="text-gray-700 mb-6">Votre demande a été enregistrée avec succès. Un expert vous contactera très rapidement pour vous présenter les aides disponibles dans votre région.</p>
                    <div class="bg-[#41b99f]/10 rounded-lg p-4 w-full max-w-lg mb-6">
                        <p class="text-[#013565] font-medium">Vous pouvez bénéficier jusqu'à 90% d'aides pour l'installation de vos panneaux solaires. Notre expert vous contactera au {{ $phone }} pour vous présenter les détails.</p>
                    </div>

                    <!-- Widget Calendly pour prise de rendez-vous après formulaire soumis -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg w-full">
                        <h4 class="font-medium text-[#013565] mb-2">Prenez rendez-vous dès maintenant avec un expert</h4>
                        <p class="text-gray-600 mb-4">Sélectionnez une date et heure qui vous convient pour discuter de votre projet avec un de nos experts.</p>

                        <!-- Intégration par iframe directe -->
                        <iframe
                            src="https://calendly.com/la-factory-lead?hide_gdpr_banner=1&name={{ urlencode($first_name . ' ' . $last_name) }}&email={{ urlencode($email) }}&a1={{ urlencode($phone) }}"
                            width="100%"
                            height="630"
                            frameborder="0"
                            title="Sélectionnez une date pour votre rendez-vous"
                            allow="camera; microphone; fullscreen; payment"
                        ></iframe>
                    </div>

                    <div class="mt-8">
                        <a href="/" class="px-6 py-3 bg-[#013565] text-white font-medium rounded-md hover:bg-[#013565]/90 transition-colors">
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        @else
            <form wire:submit.prevent="handleEnterKey" class="bg-white rounded-xl shadow-md p-6">
                @if($step == 1)
                    <h2 class="text-2xl font-bold text-[#013565] mb-6">Réduisez votre facture d'électricité jusqu'à 85%</h2>
                    <p class="text-gray-700 mb-4">Veuillez compléter ce formulaire pour vérifier votre éligibilité aux aides pour l'installation de panneaux solaires.</p>
                @else
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-[#013565]">Étape {{ $step }} sur {{ $totalSteps }}</h2>
                        <div class="w-32 h-2 bg-gray-200 rounded-full">
                            <div class="h-2 bg-[#41b99f] rounded-full" style="width: {{ ($step / $totalSteps) * 100 }}%"></div>
                        </div>
                    </div>
                @endif

                @if($step == 1)
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Quel est le montant de votre facture d'électricité chaque mois ?</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center p-3 border rounded cursor-pointer @if($energy_bill === 'less_100') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                <input type="radio" name="energy_bill" wire:model="energy_bill" value="less_100" class="mr-2">
                                <span>0 - 100€ /mois</span>
                            </label>
                            <label class="flex items-center p-3 border rounded cursor-pointer @if($energy_bill === '100_200') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                <input type="radio" name="energy_bill" wire:model="energy_bill" value="100_200" class="mr-2">
                                <span>100 - 200€ /mois</span>
                            </label>
                            <label class="flex items-center p-3 border rounded cursor-pointer @if($energy_bill === '200_300') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                <input type="radio" name="energy_bill" wire:model="energy_bill" value="200_300" class="mr-2">
                                <span>200 - 300€ /mois</span>
                            </label>
                            <label class="flex items-center p-3 border rounded cursor-pointer @if($energy_bill === 'more_300') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                <input type="radio" name="energy_bill" wire:model="energy_bill" value="more_300" class="mr-2">
                                <span>300€ et + /mois</span>
                            </label>
                        </div>
                        @error('energy_bill') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                @elseif($step == 2)
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Vous vivez dans...</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3">
                            <label class="flex items-center p-3 border rounded cursor-pointer @if($property_type == 'maison') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                <input type="radio" name="property_type" wire:model="property_type" value="maison" class="mr-2">
                                <span>Une maison</span>
                            </label>
                            <label class="flex items-center p-3 border rounded cursor-pointer @if($property_type == 'appartement') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                <input type="radio" name="property_type" wire:model="property_type" value="appartement" class="mr-2">
                                <span>Un appartement</span>
                            </label>
                        </div>
                        @error('property_type') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror

                        <div class="mt-4">
                            <label class="flex items-center p-3 border rounded">
                                <input type="checkbox" wire:model="confirm_owner" class="mr-2">
                                <span>Je confirme être propriétaire du bien</span>
                            </label>
                            @error('confirm_owner') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @elseif($step == 3)
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Quel est votre mode de chauffage actuel ?</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-3">
                            <label class="flex items-center p-3 border rounded cursor-pointer @if($heating_type == 'electrique') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                <input type="radio" name="heating_type" wire:model="heating_type" value="electrique" class="mr-2">
                                <span>Électrique</span>
                            </label>
                            <label class="flex items-center p-3 border rounded cursor-pointer @if($heating_type == 'fioul') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                <input type="radio" name="heating_type" wire:model="heating_type" value="fioul" class="mr-2">
                                <span>Fioul</span>
                            </label>
                            <label class="flex items-center p-3 border rounded cursor-pointer @if($heating_type == 'gaz') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                <input type="radio" name="heating_type" wire:model="heating_type" value="gaz" class="mr-2">
                                <span>Gaz</span>
                            </label>
                            <label class="flex items-center p-3 border rounded cursor-pointer @if($heating_type == 'bois') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                <input type="radio" name="heating_type" wire:model="heating_type" value="bois" class="mr-2">
                                <span>Bois</span>
                            </label>
                            <label class="flex items-center p-3 border rounded cursor-pointer @if($heating_type == 'autre') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                <input type="radio" name="heating_type" wire:model="heating_type" value="autre" class="mr-2">
                                <span>Autre</span>
                            </label>
                        </div>
                        @error('heating_type') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                @elseif($step == 4)
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Votre situation professionnelle</label>
                        <div class="grid grid-cols-1 gap-4 mt-3">
                            <label class="flex items-center p-3 border rounded cursor-pointer @if($professional_situation == 'stable') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                <input type="radio" name="professional_situation" wire:model="professional_situation" value="stable" class="mr-2">
                                <span>CDI, Retraité, Indépendant</span>
                            </label>
                            <label class="flex items-center p-3 border rounded cursor-pointer @if($professional_situation == 'precaire') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                <input type="radio" name="professional_situation" wire:model="professional_situation" value="precaire" class="mr-2">
                                <span>CDD, Chômage, Autre</span>
                            </label>
                        </div>
                        @error('professional_situation') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                @elseif($step == 5)
                    @if($professional_situation === 'stable')
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Comment souhaitez-vous financer votre projet énergétique ?</label>
                            <div class="grid grid-cols-1 gap-4 mt-3">
                                <label class="flex items-center p-3 border rounded cursor-pointer @if($financing_method == 'auto') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="radio" name="financing_method" wire:model="financing_method" value="auto" class="mr-2">
                                    <span>Auto financement</span>
                                </label>
                                <label class="flex items-center p-3 border rounded cursor-pointer @if($financing_method == 'credit') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="radio" name="financing_method" wire:model="financing_method" value="credit" class="mr-2">
                                    <span>Financement</span>
                                </label>
                            </div>
                            <div class="mt-4">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="accept_aid" class="mr-2">
                                    <span class="text-sm text-gray-600">Je souhaite être informé et bénéficier des aides de l'état (facultatif)</span>
                                </label>
                            </div>
                            @error('financing_method') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @else
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Votre situation matrimoniale</label>
                            <div class="grid grid-cols-1 gap-4 mt-3">
                                <label class="flex items-center p-3 border rounded cursor-pointer @if($marital_status == 'marie') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="radio" name="marital_status" wire:model="marital_status" value="marie" class="mr-2">
                                    <span>Marié</span>
                                </label>
                                <label class="flex items-center p-3 border rounded cursor-pointer @if($marital_status == 'concubinage') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="radio" name="marital_status" wire:model="marital_status" value="concubinage" class="mr-2">
                                    <span>Concubinage</span>
                                </label>
                                <label class="flex items-center p-3 border rounded cursor-pointer @if($marital_status == 'celibataire') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="radio" name="marital_status" wire:model="marital_status" value="celibataire" class="mr-2">
                                    <span>Célibataire</span>
                                </label>
                            </div>
                            @error('marital_status') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @endif
                @elseif($step == 6)
                    @if($professional_situation === 'stable' && $financing_method === 'credit')
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Avez-vous des crédits en cours ?</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3">
                                <label class="flex items-center p-3 border rounded cursor-pointer @if($has_credits === true) bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="radio" name="has_credits" wire:model="has_credits" value="1" class="mr-2">
                                    <span>Oui</span>
                                </label>
                                <label class="flex items-center p-3 border rounded cursor-pointer @if($has_credits === false) bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="radio" name="has_credits" wire:model="has_credits" value="0" class="mr-2">
                                    <span>Non</span>
                                </label>
                            </div>
                            @error('has_credits') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @elseif($professional_situation === 'precaire' && in_array($marital_status, ['marie', 'concubinage']))
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Situation professionnelle du conjoint</label>
                            <div class="grid grid-cols-1 gap-4 mt-3">
                                <label class="flex items-center p-3 border rounded cursor-pointer @if($spouse_professional_situation == 'stable') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="radio" name="spouse_professional_situation" wire:model="spouse_professional_situation" value="stable" class="mr-2">
                                    <span>CDI, Retraité, Indépendant</span>
                                </label>
                                <label class="flex items-center p-3 border rounded cursor-pointer @if($spouse_professional_situation == 'precaire') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="radio" name="spouse_professional_situation" wire:model="spouse_professional_situation" value="precaire" class="mr-2">
                                    <span>CDD, Chômage, Autre</span>
                                </label>
                            </div>
                            @error('spouse_professional_situation') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @else
                        <div class="mb-6">
                            <label for="fiscal_reference_income" class="block text-gray-700 font-medium mb-2">Quel est votre revenu fiscal de référence ?</label>
                            <input type="number" wire:model="fiscal_reference_income" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#41b99f] focus:border-transparent" placeholder="Montant en euros">
                            @error('fiscal_reference_income') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @endif
                @elseif($step == 7)
                    @if($professional_situation === 'stable' && $financing_method === 'credit' && $has_credits)
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Quels types de crédits avez-vous souscrits ?</label>
                            <div class="grid grid-cols-1 gap-4 mt-3">
                                <label class="flex items-center p-3 border rounded cursor-pointer @if(in_array('immobilier', $credit_types)) bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="checkbox" wire:change="setCreditType('immobilier', $event.target.checked)" @if(in_array('immobilier', $credit_types)) checked @endif class="mr-2">
                                    <span>Immobilier</span>
                                </label>
                                <label class="flex items-center p-3 border rounded cursor-pointer @if(in_array('consommation', $credit_types)) bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="checkbox" wire:change="setCreditType('consommation', $event.target.checked)" @if(in_array('consommation', $credit_types)) checked @endif class="mr-2">
                                    <span>Consommation</span>
                                </label>
                                <label class="flex items-center p-3 border rounded cursor-pointer @if(in_array('renouvelable', $credit_types)) bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="checkbox" wire:change="setCreditType('renouvelable', $event.target.checked)" @if(in_array('renouvelable', $credit_types)) checked @endif class="mr-2">
                                    <span>Renouvelable</span>
                                </label>
                            </div>
                            @error('credit_types') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @elseif($professional_situation === 'precaire' && in_array($marital_status, ['marie', 'concubinage']) && $spouse_professional_situation === 'stable')
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Comment souhaitez-vous financer votre projet énergétique ?</label>
                            <div class="grid grid-cols-1 gap-4 mt-3">
                                <label class="flex items-center p-3 border rounded cursor-pointer @if($financing_method == 'auto') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="radio" name="financing_method" wire:model="financing_method" value="auto" class="mr-2">
                                    <span>Auto financement</span>
                                </label>
                                <label class="flex items-center p-3 border rounded cursor-pointer @if($financing_method == 'credit') bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="radio" name="financing_method" wire:model="financing_method" value="credit" class="mr-2">
                                    <span>Financement</span>
                                </label>
                            </div>
                            <div class="mt-4">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="accept_aid" class="mr-2">
                                    <span class="text-sm text-gray-600">Je souhaite être informé et bénéficier des aides de l'état (facultatif)</span>
                                </label>
                            </div>
                            @error('financing_method') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @else
                        <div class="mb-6">
                            <label for="postal_code" class="block text-gray-700 font-medium mb-2">Quel est votre code postal ?</label>
                            <input type="text" wire:model="postal_code" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#41b99f] focus:border-transparent" placeholder="Entrez votre code postal" maxlength="5">
                            @error('postal_code') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @endif
                @elseif($step == 8)
                    @if($professional_situation === 'stable' && $financing_method === 'credit' && $has_credits)
                        <div class="mb-6">
                            <label for="credit_monthly_amount" class="block text-gray-700 font-medium mb-2">Montant total de vos mensualités de crédits</label>
                            <input type="number" wire:model="credit_monthly_amount" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#41b99f] focus:border-transparent" placeholder="Montant en euros">
                            @error('credit_monthly_amount') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @elseif($professional_situation === 'precaire' && in_array($marital_status, ['marie', 'concubinage']) && $spouse_professional_situation === 'stable' && $financing_method === 'credit')
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Avez-vous des crédits en cours ?</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3">
                                <label class="flex items-center p-3 border rounded cursor-pointer @if($has_credits === true) bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="radio" name="has_credits" wire:model="has_credits" value="1" class="mr-2">
                                    <span>Oui</span>
                                </label>
                                <label class="flex items-center p-3 border rounded cursor-pointer @if($has_credits === false) bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="radio" name="has_credits" wire:model="has_credits" value="0" class="mr-2">
                                    <span>Non</span>
                                </label>
                            </div>
                            @error('has_credits') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @else
                        <div class="mb-6">
                            <h3 class="font-medium text-lg text-[#013565] mb-4">Votre profil</h3>

                            <label for="full_name" class="block text-gray-700 font-medium mb-2">Quel est votre nom complet ?</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <input type="text" wire:model="first_name" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#41b99f] focus:border-transparent" placeholder="Prénom">
                                <input type="text" wire:model="last_name" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#41b99f] focus:border-transparent" placeholder="Nom">
                            </div>
                            @error('first_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            @error('last_name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror

                            <label for="birth_date" class="block text-gray-700 font-medium mb-2 mt-4">Quelle est votre date de naissance ?</label>
                            <input type="date" wire:model="birth_date" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#41b99f] focus:border-transparent">
                            @error('birth_date') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @endif
                @elseif($step == 9)
                    @if($professional_situation === 'stable' && $financing_method === 'credit' && $has_credits)
                        <div class="mb-6">
                            <label for="fiscal_reference_income" class="block text-gray-700 font-medium mb-2">Quel est votre revenu fiscal de référence ?</label>
                            <input type="number" wire:model="fiscal_reference_income" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#41b99f] focus:border-transparent" placeholder="Montant en euros">
                            @error('fiscal_reference_income') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @elseif($professional_situation === 'precaire' && in_array($marital_status, ['marie', 'concubinage']) && $spouse_professional_situation === 'stable' && $financing_method === 'credit' && $has_credits)
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-2">Quels types de crédits avez-vous souscrits ?</label>
                            <div class="grid grid-cols-1 gap-4 mt-3">
                                <label class="flex items-center p-3 border rounded cursor-pointer @if(in_array('immobilier', $credit_types)) bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="checkbox" wire:change="setCreditType('immobilier', $event.target.checked)" @if(in_array('immobilier', $credit_types)) checked @endif class="mr-2">
                                    <span>Immobilier</span>
                                </label>
                                <label class="flex items-center p-3 border rounded cursor-pointer @if(in_array('consommation', $credit_types)) bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="checkbox" wire:change="setCreditType('consommation', $event.target.checked)" @if(in_array('consommation', $credit_types)) checked @endif class="mr-2">
                                    <span>Consommation</span>
                                </label>
                                <label class="flex items-center p-3 border rounded cursor-pointer @if(in_array('renouvelable', $credit_types)) bg-blue-50 border-blue-500 @else hover:bg-gray-50 @endif">
                                    <input type="checkbox" wire:change="setCreditType('renouvelable', $event.target.checked)" @if(in_array('renouvelable', $credit_types)) checked @endif class="mr-2">
                                    <span>Renouvelable</span>
                                </label>
                            </div>
                            @error('credit_types') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @else
                        <div class="mb-6">
                            <h3 class="font-medium text-lg text-[#013565] mb-4">Informations de contact</h3>

                            <label for="email" class="block text-gray-700 font-medium mb-2">Quelle est votre adresse email ?</label>
                            <input type="email" wire:model="email" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#41b99f] focus:border-transparent" placeholder="exemple@domaine.fr">
                            @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror

                            <label for="phone" class="block text-gray-700 font-medium mb-2 mt-4">Quel est votre numéro de téléphone ?</label>
                            <input type="tel" wire:model="phone" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#41b99f] focus:border-transparent" placeholder="06 XX XX XX XX">
                            @error('phone') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            <p class="text-gray-500 text-sm mt-2">Nous vous contacterons uniquement pour vous présenter les aides disponibles</p>

                            <div class="mt-4">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="optin" class="mr-2">
                                    <span class="text-sm text-gray-600">J'accepte de recevoir des informations sur les aides disponibles</span>
                                </label>
                            </div>
                        </div>
                    @endif
                @elseif($step == 10)
                    @if($professional_situation === 'precaire' && in_array($marital_status, ['marie', 'concubinage']) && $spouse_professional_situation === 'stable' && $financing_method === 'credit' && $has_credits)
                        <div class="mb-6">
                            <label for="credit_monthly_amount" class="block text-gray-700 font-medium mb-2">Montant total de vos mensualités de crédits</label>
                            <input type="number" wire:model="credit_monthly_amount" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#41b99f] focus:border-transparent" placeholder="Montant en euros">
                            @error('credit_monthly_amount') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @else
                        <div class="mb-6">
                            <h3 class="font-medium text-lg text-[#013565] mb-4">Confirmation</h3>
                            <p class="text-gray-700 mb-4">Merci pour les informations fournies. Veuillez confirmer votre soumission pour finaliser votre demande.</p>
                        </div>
                    @endif
                @elseif($step == 11)
                    @if($professional_situation === 'precaire' && in_array($marital_status, ['marie', 'concubinage']) && $spouse_professional_situation === 'stable' && $financing_method === 'credit' && $has_credits)
                        <div class="mb-6">
                            <label for="fiscal_reference_income" class="block text-gray-700 font-medium mb-2">Quel est votre revenu fiscal de référence ?</label>
                            <input type="number" wire:model="fiscal_reference_income" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#41b99f] focus:border-transparent" placeholder="Montant en euros">
                            @error('fiscal_reference_income') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    @endif
                @endif

                <div class="flex justify-between mt-8">
                    @if($step > 1)
                        <button type="button" wire:click="prevStep" class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-md hover:bg-gray-200 transition-colors">Précédent</button>
                    @else
                        <div></div>
                    @endif

                    @if($step < $totalSteps)
                        <button type="button" wire:click="nextStep" class="px-6 py-3 bg-[#013565] text-white font-medium rounded-md hover:bg-[#013565]/90 transition-colors">Suivant</button>
                    @else
                        <div class="flex flex-col gap-2">
                            @if($isEligible)
                                <button type="button" wire:click="submit" wire:loading.attr="disabled" class="px-6 py-3 bg-[#41b99f] text-white font-medium rounded-md hover:bg-[#41b99f]/90 transition-colors">
                                    <span wire:loading.remove wire:target="submit">Valider mon rendez-vous</span>
                                    <span wire:loading wire:target="submit">Traitement en cours...</span>
                                </button>
                            @else
                                <button type="button" wire:click="submit" wire:loading.attr="disabled" class="px-6 py-3 bg-[#41b99f] text-white font-medium rounded-md hover:bg-[#41b99f]/90 transition-colors">
                                    <span wire:loading.remove wire:target="submit">Tester mon éligibilité</span>
                                    <span wire:loading wire:target="submit">Traitement en cours...</span>
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </form>

            @if(session('error'))
                <div class="mt-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Form component loaded');

        // Écouter les événements personnalisés
        window.addEventListener('alert', event => {
            alert(event.detail.message);
        });

        // Patch pour les boutons si nécessaire
        document.querySelectorAll('button[wire\\:click]').forEach(button => {
            console.log('Found wire:click button:', button.outerHTML);
            button.addEventListener('click', function(e) {
                console.log('Button clicked:', this.outerHTML);
            });
        });
    });
</script>
