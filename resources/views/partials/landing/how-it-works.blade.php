<!-- Section Comment ça marche -->
<div id="how-it-works" class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold font-marianne text-center mb-12">
            {{ $landing->getValueOrDefault('how_title', 'Comment ça marche ?') }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Étape 1 -->
            <div class="flex flex-col items-center p-6 rounded-lg">
                <div class="rounded-full bg-[{{ $landing->getValueOrDefault('blue_color', '#00467F') }}] h-20 w-20 flex items-center justify-center mb-4">
                    <span class="text-white text-3xl font-bold">1</span>
                </div>
                <h3 class="text-xl font-bold font-marianne mb-2 text-center">
                    {{ $landing->getValueOrDefault('step1_title', 'Remplissez le formulaire') }}
                </h3>
                <p class="text-gray-700 text-center font-marianne">
                    {{ $landing->getValueOrDefault('step1_text', 'Complétez le formulaire en quelques minutes et précisez votre situation actuelle.') }}
                </p>
            </div>

            <!-- Étape 2 -->
            <div class="flex flex-col items-center p-6 rounded-lg">
                <div class="rounded-full bg-[{{ $landing->getValueOrDefault('blue_color', '#00467F') }}] h-20 w-20 flex items-center justify-center mb-4">
                    <span class="text-white text-3xl font-bold">2</span>
                </div>
                <h3 class="text-xl font-bold font-marianne mb-2 text-center">
                    {{ $landing->getValueOrDefault('step2_title', 'Échangez avec un expert') }}
                </h3>
                <p class="text-gray-700 text-center font-marianne">
                    {{ $landing->getValueOrDefault('step2_text', 'Un expert vous contacte pour évaluer vos besoins et répondre à vos questions.') }}
                </p>
            </div>

            <!-- Étape 3 -->
            <div class="flex flex-col items-center p-6 rounded-lg">
                <div class="rounded-full bg-[{{ $landing->getValueOrDefault('blue_color', '#00467F') }}] h-20 w-20 flex items-center justify-center mb-4">
                    <span class="text-white text-3xl font-bold">3</span>
                </div>
                <h3 class="text-xl font-bold font-marianne mb-2 text-center">
                    {{ $landing->getValueOrDefault('step3_title', 'Recevez votre étude gratuite') }}
                </h3>
                <p class="text-gray-700 text-center font-marianne">
                    {{ $landing->getValueOrDefault('step3_text', 'Obtenez une étude personnalisée pour passer au solaire et économiser sur vos factures.') }}
                </p>
            </div>
        </div>
    </div>
</div>
