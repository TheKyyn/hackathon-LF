<!-- Structure identique aux autres sections -->
<div class="w-screen relative left-1/2 right-1/2 -mx-[50vw] bg-white py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Titre aligné à gauche -->
        <h2 class="text-black text-xl md:text-2xl lg:text-3xl font-bold font-marianne mb-6">{{ $landing->getValueOrDefault('providers_title', 'De plus en plus de foyers paient moins de 30€/mois grâce à ces aides. Pourquoi pas vous ?') }}</h2>

        <!-- Premier groupe -->
        <div class="w-full mb-6">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ $landing->getValueOrDefault('provider1_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider1', 'EDF') }}</span>
                </a>
                <a href="{{ $landing->getValueOrDefault('provider2_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider2', 'Engie') }}</span>
                </a>
                <a href="{{ $landing->getValueOrDefault('provider3_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider3', 'TotalEnergies') }}</span>
                </a>
                <a href="{{ $landing->getValueOrDefault('provider4_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider4', 'Eni') }}</span>
                </a>
            </div>
        </div>

        <!-- Deuxième groupe -->
        <div class="w-full mb-6">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ $landing->getValueOrDefault('provider5_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider5', 'Vattefall') }}</span>
                </a>
                <a href="{{ $landing->getValueOrDefault('provider6_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider6', 'ekWateur') }}</span>
                </a>
                <a href="{{ $landing->getValueOrDefault('provider7_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider7', 'Enercoop') }}</span>
                </a>
                <a href="{{ $landing->getValueOrDefault('provider8_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider8', 'Planète Oui') }}</span>
                </a>
            </div>
        </div>

        <!-- Troisième groupe -->
        <div class="w-full mb-6">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ $landing->getValueOrDefault('provider9_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider9', 'Plüm Énergie') }}</span>
                </a>
                <a href="{{ $landing->getValueOrDefault('provider10_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider10', 'Alpiq') }}</span>
                </a>
                <a href="{{ $landing->getValueOrDefault('provider11_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider11', 'Butagaz') }}</span>
                </a>
                <a href="{{ $landing->getValueOrDefault('provider12_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider12', 'Énergem') }}</span>
                </a>
            </div>
        </div>

        <!-- Quatrième groupe -->
        <div class="w-full mb-6">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ $landing->getValueOrDefault('provider13_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider13', 'Ilek') }}</span>
                </a>
                <a href="{{ $landing->getValueOrDefault('provider14_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider14', 'Mint Énergie') }}</span>
                </a>
                <a href="{{ $landing->getValueOrDefault('provider15_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider15', 'Méga Énergie') }}</span>
                </a>
                <a href="{{ $landing->getValueOrDefault('provider16_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider16', 'OHM Énergie') }}</span>
                </a>
            </div>
        </div>

        <!-- Cinquième groupe -->
        <div class="w-full">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ $landing->getValueOrDefault('provider17_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider17', 'Wekiwi') }}</span>
                </a>
                <a href="{{ $landing->getValueOrDefault('provider18_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider18', 'Gaz Électricité de Grenoble') }}</span>
                </a>
                <a href="{{ $landing->getValueOrDefault('provider19_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider19', 'Électricité de Strasbourg') }}</span>
                </a>
                <a href="{{ $landing->getValueOrDefault('provider20_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                    <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('provider20', 'Énergies du Santerre') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
