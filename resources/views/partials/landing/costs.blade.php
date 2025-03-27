<!-- Structure de coût avec les options personnalisées -->
<div class="w-screen relative left-1/2 right-1/2 -mx-[50vw] bg-white py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-black text-xl md:text-2xl lg:text-[26px] font-bold font-marianne mb-6">{{ $landing->getValueOrDefault('costs_title', 'Quelle est votre facture d\'électricité mensuelle ?') }}</h2>

        <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ $landing->getValueOrDefault('costs_option1_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('costs_option1', '0 - 50€') }}</span>
            </a>
            <a href="{{ $landing->getValueOrDefault('costs_option2_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('costs_option2', '50 - 100€') }}</span>
            </a>
            <a href="{{ $landing->getValueOrDefault('costs_option3_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('costs_option3', '100 - 150€') }}</span>
            </a>
            <a href="{{ $landing->getValueOrDefault('costs_option4_url', route('form')) }}" class="border border-gray-300 rounded-lg p-4 flex items-center justify-center text-center hover:bg-gray-50 transition duration-300">
                <span class="text-black text-lg font-medium">{{ $landing->getValueOrDefault('costs_option4', '+150€') }}</span>
            </a>
        </div>
    </div>
</div>
