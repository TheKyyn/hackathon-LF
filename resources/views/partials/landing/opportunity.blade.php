<div class="w-screen relative left-1/2 right-1/2 -mx-[50vw] bg-white py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="self-stretch flex flex-col justify-center items-start gap-[25px] mb-8">
            <h2 class="self-stretch text-black text-[26px] font-bold font-marianne">{{ $landing->getValueOrDefault('opportunity_title', 'Une opportunité massive, mais peu connue') }}</h2>

            <div class="self-stretch flex flex-col justify-start items-start gap-[15px]">
                <p class="self-stretch text-black text-xl font-normal font-marianne leading-[30px]">
                    {!! $landing->getValueOrDefault('opportunity_paragraph1', 'Aujourd\'hui, <strong class="font-bold">90 % des foyers éligibles ne font pas valoir leurs droits</strong>, par manque d\'information ou par méconnaissance des démarches à suivre. Pourtant, l\'autoconsommation permet non seulement de <strong class="font-bold">réduire ses factures jusqu\'à 85 %</strong>, mais aussi de générer un revenu complémentaire en revendant l\'électricité excédentaire à EDF.') !!}
                </p>
                <p class="self-stretch text-black text-xl font-normal font-marianne leading-[30px]">
                    {!! $landing->getValueOrDefault('opportunity_paragraph2', 'Si vous êtes propriétaire et que vous n\'avez pas encore franchi le pas, <strong class="font-bold">c\'est le moment de s\'informer.</strong>') !!}
                </p>
            </div>
        </div>

        <div
            class="self-stretch px-6 md:px-[110px] py-10 bg-[{{ $landing->getValueOrDefault('opportunity_bg_color', '#013565') }}]/5 rounded flex flex-col justify-start items-start gap-5">
            <p class="self-stretch text-black text-xl font-normal font-marianne">
                {!! $landing->getValueOrDefault('opportunity_warning', '<strong class="font-bold">⚠️ Attention : ces aides sont limitées et attribuées selon l\'ordre des demandes.</strong> Il est possible de faire valoir son éligibilité dès maintenant afin de sécuriser son accès aux subventions, même si l\'installation se fait plus tard.') !!}
            </p>

            <div
                class="h-[60px] px-[30px] py-2.5 bg-[{{ $landing->getValueOrDefault('opportunity_btn_color', '#013565') }}] rounded outline outline-1 outline-offset-[-1px] outline-[{{ $landing->getValueOrDefault('opportunity_btn_color', '#013565') }}] inline-flex justify-center items-center gap-3">
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.6402 13.7365C12.8682 13.5465 13 13.2651 13 12.9683C13 12.6715 12.8682 12.3901 12.6402 12.2001L6.64018 7.20007C6.2159 6.8465 5.58534 6.90383 5.23177 7.3281C4.87821 7.75238 4.93553 8.38294 5.35981 8.73651L10.4379 12.9683L5.35981 17.2001C4.93553 17.5536 4.87821 18.1842 5.23177 18.6085C5.58534 19.0327 6.2159 19.0901 6.64018 18.7365L12.6402 13.7365Z"
                        fill="white" />
                    <path opacity="0.5"
                        d="M18.6402 13.7365C18.8682 13.5465 19 13.2651 19 12.9683C19 12.6715 18.8682 12.3901 18.6402 12.2001L12.6402 7.20007C12.2159 6.8465 11.5853 6.90383 11.2318 7.3281C10.8782 7.75238 10.9355 8.38294 11.3598 8.73651L16.4379 12.9683L11.3598 17.2001C10.9355 17.5536 10.8782 18.1842 11.2318 18.6085C11.5853 19.0327 12.2159 19.0901 12.6402 18.7365L18.6402 13.7365Z"
                        fill="white" />
                </svg>
                <a href="{{ $landing->getValueOrDefault('opportunity_btn_url', route('form')) }}" class="text-right justify-start text-white text-lg font-bold font-marianne uppercase">{{ $landing->getValueOrDefault('opportunity_btn_text', 'vérifier votre éligibilité') }}</a>
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M11.3598 12.2C11.1318 12.39 11 12.6715 11 12.9682C11 13.265 11.1318 13.5465 11.3598 13.7365L17.3598 18.7365C17.7841 19.09 18.4146 19.0327 18.7682 18.6084C19.1218 18.1841 19.0644 17.5536 18.6402 17.2L13.562 12.9682L18.6402 8.73646C19.0644 8.38289 19.1218 7.75233 18.7682 7.32805C18.4146 6.90378 17.7841 6.84645 17.3598 7.20002L11.3598 12.2Z"
                        fill="white" />
                    <path opacity="0.5"
                        d="M5.35979 12.2C5.1318 12.39 4.99998 12.6715 4.99998 12.9682C4.99998 13.265 5.1318 13.5465 5.35979 13.7365L11.3598 18.7365C11.7841 19.09 12.4146 19.0327 12.7682 18.6084C13.1218 18.1841 13.0644 17.5536 12.6402 17.2L7.56203 12.9682L12.6402 8.73646C13.0644 8.38289 13.1218 7.75233 12.7682 7.32805C12.4146 6.90378 11.7841 6.84645 11.3598 7.20002L5.35979 12.2Z"
                        fill="white" />
                </svg>
            </div>
        </div>
    </div>
</div>