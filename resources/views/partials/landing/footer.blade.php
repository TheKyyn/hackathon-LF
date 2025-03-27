<!-- Footer avec largeur pleine page -->
<div class="w-screen relative left-1/2 right-1/2 -mx-[50vw] bg-[#f2f5f7] py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="w-full flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex flex-col">
                @if($landing->isCustomized('footer_logo'))
                    <img src="{{ asset('storage/' . $landing->footer_logo) }}" alt="Logo" class="h-12" />
                @else
                    <img src="{{ asset('images/landing/svgs/FIE.svg') }}" alt="France Info Énergie" class="h-12" />
                @endif
            </div>
            <div class="flex flex-col md:flex-row items-center gap-4 md:gap-8">
                <div class="flex items-center gap-2.5">
                    <a href="{{ $landing->getValueOrDefault('mentions_url', '#') }}" class="text-black text-xs font-normal font-marianne underline">{{ $landing->getValueOrDefault('mentions_text', 'Mentions légales') }}</a>
                    <div class="w-px h-4 bg-black"></div>
                    <a href="{{ $landing->getValueOrDefault('privacy_url', '#') }}" class="text-black text-xs font-normal font-marianne underline">{{ $landing->getValueOrDefault('privacy_text', 'Politique de confidentialité') }}</a>
                </div>
                @if($landing->isCustomized('footer_image'))
                    <img class="w-48 h-8" src="{{ asset('storage/' . $landing->footer_image) }}" alt="Logo footer" />
                @else
                    <img class="w-48 h-8" src="{{ asset('images/landing/imgs/footer.png') }}" alt="Logo gouvernement" />
                @endif
            </div>
        </div>
    </div>
</div>
