<div class="w-screen relative left-1/2 right-1/2 -mx-[50vw] bg-white py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Titre aligné à gauche -->
        <h2 class="text-black text-xl md:text-2xl lg:text-[26px] font-bold font-marianne mb-6">{{ $landing->getValueOrDefault('innovation_title', '872 000 foyers équipés : l\'innovation qui change tout') }}</h2>

        <!-- Images centrées -->
        <div class="w-full flex flex-col md:flex-row justify-center items-center gap-6 mb-6">
            @if($landing->isCustomized('innovation_image1'))
                <img class="w-full md:w-2/3 lg:w-[478px] h-auto rounded-lg" src="{{ asset('storage/' . $landing->innovation_image1) }}" alt="Panneaux solaires" />
            @else
                <img class="w-full md:w-2/3 lg:w-[478px] h-auto rounded-lg" src="{{ asset('images/landing/imgs/tech-aero.png') }}" alt="Panneaux solaires" />
            @endif

            @if($landing->isCustomized('innovation_image2'))
                <img class="w-32 h-32 md:w-[150px] md:h-[150px]" src="{{ asset('storage/' . $landing->innovation_image2) }}" alt="Badge efficacité" />
            @else
                <img class="w-32 h-32 md:w-[150px] md:h-[150px]" src="{{ asset('landing/efficiency-badge.png') }}" alt="Badge efficacité" />
            @endif
        </div>

        <!-- Textes alignés à gauche -->
        <div class="w-full flex flex-col justify-start items-start gap-6 mb-6">
            <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne leading-relaxed">
                {{ $landing->getValueOrDefault('innovation_paragraph1', 'Cette année, des centaines de milliers de foyers ont fait le choix du solaire, et ce n\'est pas un hasard.') }}
            </p>
            <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne leading-relaxed">
                {{ $landing->getValueOrDefault('innovation_paragraph2', 'L\'innovation majeure réside dans <u>les panneaux solaires aérovoltaïques.</u>') }}
            </p>
            <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne leading-relaxed">
                {{ $landing->getValueOrDefault('innovation_paragraph3', 'Ces systèmes hybrides permettent de :') }}
            </p>
        </div>

        <div class="w-full flex flex-col justify-start items-start gap-6 mb-6">
            <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne leading-relaxed">
                {!! $landing->getValueOrDefault('innovation_point1', '<strong class="font-bold">✔ Produire 80% d\'électricité supplémentaire</strong>, même par temps couvert.') !!}
            </p>
            <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne leading-relaxed">
                {!! $landing->getValueOrDefault('innovation_point2', '✔ Récupérer la chaleur générée pour <strong class="font-bold">chauffer votre habitation en hiver.</strong>') !!}
            </p>
            <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne leading-relaxed">
                {!! $landing->getValueOrDefault('innovation_point3', '<strong class="font-bold">✔ Rafraîchir l\'air en été.</strong>') !!}
            </p>
        </div>

        <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne leading-relaxed">
            {{ $landing->getValueOrDefault('innovation_conclusion', 'Si vous cherchez une solution énergétique innovante et économique pour votre maison, c\'est peut-être le moment d\'agir.') }}
        </p>
    </div>
</div>
