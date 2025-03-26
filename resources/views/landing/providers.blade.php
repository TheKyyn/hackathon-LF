<!-- Structure identique aux autres sections -->
<div class="w-screen relative left-1/2 right-1/2 -mx-[50vw] bg-white py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Titre aligné à gauche -->
        <h2 class="text-black text-xl md:text-2xl lg:text-3xl font-bold font-marianne mb-6">De plus en plus de foyers paient moins de 30€/mois grâce à ces aides. Pourquoi pas vous ?</h2>

        <!-- Premier groupe -->
        <div class="w-full mb-6">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <x-landing.provider-option name="EDF" />
                <x-landing.provider-option name="Engie" />
                <x-landing.provider-option name="TotalEnergies" />
                <x-landing.provider-option name="Eni" />
            </div>
        </div>

        <!-- Deuxième groupe -->
        <div class="w-full mb-6">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <x-landing.provider-option name="Vattefall" />
                <x-landing.provider-option name="ekWateur" />
                <x-landing.provider-option name="Enercoop" />
                <x-landing.provider-option name="Planète Oui" />
            </div>
        </div>

        <!-- Troisième groupe -->
        <div class="w-full mb-6">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <x-landing.provider-option name="Plüm Énergie" />
                <x-landing.provider-option name="Alpiq" />
                <x-landing.provider-option name="Butagaz" />
                <x-landing.provider-option name="Énergem" />
            </div>
        </div>

        <!-- Quatrième groupe -->
        <div class="w-full mb-6">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <x-landing.provider-option name="Ilek" />
                <x-landing.provider-option name="Mint Énergie" multiline="true" />
                <x-landing.provider-option name="Méga Énergie" />
                <x-landing.provider-option name="OHM Énergie" />
            </div>
        </div>

        <!-- Cinquième groupe -->
        <div class="w-full">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <x-landing.provider-option name="Wekiwi" />
                <x-landing.provider-option name="Gaz Électricité de Grenoble" multiline="true" />
                <x-landing.provider-option name="Électricité de Strasbourg" multiline="true" />
                <x-landing.provider-option name="Énergies du Santerre" multiline="true" />
            </div>
        </div>
    </div>
</div>
