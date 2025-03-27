<!-- Bloc CTA -->
<div class="w-full bg-[{{ $landing->getValueOrDefault('blue_color', '#00467F') }}] py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center">
        <h2 class="text-white text-3xl md:text-4xl font-bold font-marianne text-center mb-8">
            {{ $landing->getValueOrDefault('cta_title', 'Profitez dès maintenant de votre étude gratuite') }}
        </h2>
        <p class="text-white text-lg font-normal font-marianne text-center mb-10 max-w-3xl">
            {{ $landing->getValueOrDefault('cta_text', 'Remplissez le formulaire ci-dessous pour être contacté par un expert et bénéficier d\'une étude gratuite et personnalisée.') }}
        </p>
        <a href="#form-section" class="px-8 py-3 bg-white text-[{{ $landing->getValueOrDefault('blue_color', '#00467F') }}] font-bold rounded-lg shadow-md hover:bg-gray-100 transition-all">
            {{ $landing->getValueOrDefault('cta_button', 'Je fais ma demande gratuitement') }}
        </a>
    </div>
</div>
