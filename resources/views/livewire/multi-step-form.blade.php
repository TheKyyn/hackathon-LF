<div class="max-w-3xl mx-auto px-4 py-6">
    <div class="mb-8">
        <div class="flex justify-center">
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ ($step / $totalSteps) * 100 }}%"></div>
            </div>
        </div>
        <div class="flex justify-between mt-2 text-sm text-gray-500">
            <span>Étape {{ $step }}/{{ $totalSteps }}</span>
            <span>{{ intval(($step / $totalSteps) * 100) }}% complété</span>
        </div>
    </div>

    <form wire:submit.prevent="nextStep">
        <!-- Étape 1: Type d'énergie -->
        @if($step === 1)
            <div class="form-step">
                <h2 class="form-step-title">Quel type d'installation vous intéresse ?</h2>
                <div class="form-grid">
                    @foreach($energyTypes as $value => $label)
                        <label class="border p-4 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $energy_type === $value ? 'bg-blue-50 border-blue-500' : 'border-gray-300' }}">
                            <input type="radio" wire:model="energy_type" value="{{ $value }}" class="hidden">
                            <div class="flex items-center">
                                <div class="w-6 h-6 border border-gray-400 rounded-full flex items-center justify-center mr-3 {{ $energy_type === $value ? 'bg-blue-600 border-blue-600' : '' }}">
                                    @if($energy_type === $value)
                                        <div class="w-3 h-3 bg-white rounded-full"></div>
                                    @endif
                                </div>
                                <span>{{ $label }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('energy_type') <div class="mt-2 text-red-600">{{ $message }}</div> @enderror
            </div>
        @endif

        <!-- Étape 2: Type de propriété -->
        @if($step === 2)
            <div class="form-step">
                <h2 class="form-step-title">Quel est votre type de logement ?</h2>
                <div class="form-grid">
                    @foreach($propertyTypes as $value => $label)
                        <label class="border p-4 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $property_type === $value ? 'bg-blue-50 border-blue-500' : 'border-gray-300' }}">
                            <input type="radio" wire:model="property_type" value="{{ $value }}" class="hidden">
                            <div class="flex items-center">
                                <div class="w-6 h-6 border border-gray-400 rounded-full flex items-center justify-center mr-3 {{ $property_type === $value ? 'bg-blue-600 border-blue-600' : '' }}">
                                    @if($property_type === $value)
                                        <div class="w-3 h-3 bg-white rounded-full"></div>
                                    @endif
                                </div>
                                <span>{{ $label }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('property_type') <div class="mt-2 text-red-600">{{ $message }}</div> @enderror
            </div>
        @endif

        <!-- Étape 3: Propriétaire ou locataire -->
        @if($step === 3)
            <div class="form-step">
                <h2 class="form-step-title">Êtes-vous propriétaire de ce logement ?</h2>
                <div class="form-grid">
                    <label class="border p-4 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $is_owner === true ? 'bg-blue-50 border-blue-500' : 'border-gray-300' }}">
                        <input type="radio" wire:model="is_owner" value="1" class="hidden">
                        <div class="flex items-center">
                            <div class="w-6 h-6 border border-gray-400 rounded-full flex items-center justify-center mr-3 {{ $is_owner === true ? 'bg-blue-600 border-blue-600' : '' }}">
                                @if($is_owner === true)
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                @endif
                            </div>
                            <span>Oui, je suis propriétaire</span>
                        </div>
                    </label>
                    <label class="border p-4 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $is_owner === false ? 'bg-blue-50 border-blue-500' : 'border-gray-300' }}">
                        <input type="radio" wire:model="is_owner" value="0" class="hidden">
                        <div class="flex items-center">
                            <div class="w-6 h-6 border border-gray-400 rounded-full flex items-center justify-center mr-3 {{ $is_owner === false ? 'bg-blue-600 border-blue-600' : '' }}">
                                @if($is_owner === false)
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                @endif
                            </div>
                            <span>Non, je suis locataire</span>
                        </div>
                    </label>
                </div>
                @error('is_owner') <div class="mt-2 text-red-600">{{ $message }}</div> @enderror
            </div>
        @endif

        <!-- Étape 4: A un projet en cours -->
        @if($step === 4)
            <div class="form-step">
                <h2 class="form-step-title">Avez-vous un projet en cours ?</h2>
                <div class="form-grid">
                    <label class="border p-4 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $has_project === true ? 'bg-blue-50 border-blue-500' : 'border-gray-300' }}">
                        <input type="radio" wire:model="has_project" value="1" class="hidden">
                        <div class="flex items-center">
                            <div class="w-6 h-6 border border-gray-400 rounded-full flex items-center justify-center mr-3 {{ $has_project === true ? 'bg-blue-600 border-blue-600' : '' }}">
                                @if($has_project === true)
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                @endif
                            </div>
                            <span>Oui, j'ai un projet</span>
                        </div>
                    </label>
                    <label class="border p-4 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $has_project === false ? 'bg-blue-50 border-blue-500' : 'border-gray-300' }}">
                        <input type="radio" wire:model="has_project" value="0" class="hidden">
                        <div class="flex items-center">
                            <div class="w-6 h-6 border border-gray-400 rounded-full flex items-center justify-center mr-3 {{ $has_project === false ? 'bg-blue-600 border-blue-600' : '' }}">
                                @if($has_project === false)
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                @endif
                            </div>
                            <span>Non, je cherche des informations</span>
                        </div>
                    </label>
                </div>
                @error('has_project') <div class="mt-2 text-red-600">{{ $message }}</div> @enderror
            </div>
        @endif

        <!-- Étape 5: Coordonnées personnelles (nom, prénom) -->
        @if($step === 5)
            <div class="form-step">
                <h2 class="form-step-title">Vos coordonnées</h2>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="first_name">
                        Prénom
                    </label>
                    <input wire:model="first_name" id="first_name" type="text" class="form-input" placeholder="Votre prénom">
                    @error('first_name') <div class="mt-1 text-red-600 text-sm">{{ $message }}</div> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="last_name">
                        Nom
                    </label>
                    <input wire:model="last_name" id="last_name" type="text" class="form-input" placeholder="Votre nom">
                    @error('last_name') <div class="mt-1 text-red-600 text-sm">{{ $message }}</div> @enderror
                </div>
            </div>
        @endif

        <!-- Étape 6: Email -->
        @if($step === 6)
            <div class="form-step">
                <h2 class="form-step-title">Votre adresse email</h2>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input wire:model.debounce.500ms="email" id="email" type="email" class="form-input" placeholder="votre@email.com">
                    @error('email') <div class="mt-1 text-red-600 text-sm">{{ $message }}</div> @enderror
                </div>
                <div class="flex items-center mt-4">
                    <input wire:model="optin" id="optin" type="checkbox" class="w-4 h-4 text-blue-600">
                    <label for="optin" class="ml-2 text-sm text-gray-700">
                        J'accepte de recevoir des informations sur les produits et services.
                    </label>
                </div>
            </div>
        @endif

        <!-- Étape 7: Téléphone -->
        @if($step === 7)
            <div class="form-step">
                <h2 class="form-step-title">Votre numéro de téléphone</h2>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                        Téléphone mobile
                    </label>
                    <input wire:model.debounce.500ms="phone" id="phone" type="tel" class="form-input" placeholder="06XXXXXXXX ou 07XXXXXXXX">
                    @error('phone') <div class="mt-1 text-red-600 text-sm">{{ $message }}</div> @enderror
                </div>
            </div>
        @endif

        <!-- Étape 8: Adresse -->
        @if($step === 8)
            <div class="form-step">
                <h2 class="form-step-title">Votre adresse</h2>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
                        Adresse
                    </label>
                    <input wire:model="address" id="address" type="text" class="form-input" placeholder="Numéro et nom de rue">
                    @error('address') <div class="mt-1 text-red-600 text-sm">{{ $message }}</div> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="postal_code">
                        Code postal
                    </label>
                    <input wire:model="postal_code" id="postal_code" type="text" class="form-input" placeholder="XXXXX">
                    @error('postal_code') <div class="mt-1 text-red-600 text-sm">{{ $message }}</div> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="city">
                        Ville
                    </label>
                    <input wire:model="city" id="city" type="text" class="form-input" placeholder="Votre ville">
                    @error('city') <div class="mt-1 text-red-600 text-sm">{{ $message }}</div> @enderror
                </div>
            </div>
        @endif

        <!-- Boutons de navigation -->
        <div class="flex justify-between mt-6">
            @if($step > 1)
                <button type="button" wire:click="prevStep" class="form-btn-secondary">
                    Précédent
                </button>
            @else
                <div></div>
            @endif

            <button type="submit" class="form-btn">
                @if($step === $totalSteps)
                    Terminer
                @else
                    Suivant
                @endif
            </button>
        </div>
    </form>
</div>
