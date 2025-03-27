<div class="w-screen relative left-1/2 right-1/2 -mx-[50vw] bg-white py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Titre aligné à gauche -->
        <h2 class="text-black text-xl md:text-2xl lg:text-[26px] font-bold font-marianne mb-6">{{ $landing->getValueOrDefault('benefits_title', 'Pourquoi passer au solaire dès maintenant ?') }}</h2>

        <!-- Contenu avec alignement à gauche -->
        <div class="w-full flex flex-col justify-start items-start gap-6">
            <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne leading-relaxed">
                {!! $landing->getValueOrDefault('benefits_point1', '<strong class="font-bold">✔ Installation à 0€ : </strong>Selon votre situation, les aides et subventions peuvent couvrir<br class="hidden md:inline"/>100 % des coûts, sans avance de frais.') !!}
            </p>
            <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne leading-relaxed">
                {!! $landing->getValueOrDefault('benefits_point2', '<strong class="font-bold">✔ Auto-consommation & indépendance énergétique : </strong>Produisez votre propre électricité et réduisez jusqu\'à 100 % de votre facture. Stockez l\'excédent pour ne plus subir les hausses de prix.') !!}
            </p>
            <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne leading-relaxed">
                {!! $landing->getValueOrDefault('benefits_point3', '<strong class="font-bold">✔ Revenus complémentaires : </strong>Si votre production dépasse votre consommation, vous pouvez revendre votre surplus à EDF et gagnez jusqu\'à 3 000 € par an. Un investissement qui peut annuler vos factures et générer des revenus durables.') !!}
            </p>
        </div>
    </div>
</div>
