<div class="w-full px-4 md:px-8 lg:px-20 py-12 flex flex-col justify-center items-center gap-10">
    <div class="w-full flex flex-col justify-center items-center gap-6">
        <div class="w-full flex flex-col justify-start items-center gap-2">
            <h2 class="text-black text-xl md:text-2xl lg:text-[26px] font-bold font-marianne text-center">Êtes-vous éligible
                aux aides solaires ?</h2>
            <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne text-center">
                Cliquez sur votre région ci-dessous pour le savoir :
            </p>
        </div>
    </div>
    <div class="w-full md:w-[400px] h-auto md:h-[391px] relative overflow-hidden">
        <img class="w-full h-auto" src="{{ asset('images/landing/imgs/fr-map.png') }}" alt="Carte de France" />
    </div>
    <div class="w-full px-4 md:px-8 lg:px-28 py-10 bg-[#013565]/5 rounded flex flex-col justify-start items-start gap-8">
        <div class="flex flex-col gap-4 w-full">
            <div class="flex justify-start items-start w-full">
                <img src="{{ asset('images/landing/svgs/FIE.svg') }}" alt="France Info Énergie" class="h-12" />
            </div>
            <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne">
                Découvrez le montant de vos aides sur franceinfoénergie.fr
            </p>
        </div>
        <div class="w-full flex flex-col justify-start items-start gap-2">
            <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne">✔️ Jusqu'à 100% d'économies sur
                votre facture d'électricité</p>
            <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne">✔️ Aides financières selon le
                programme de l'État</p>
            <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne">✔️ Simulation du droit à la
                subvention et coût des travaux</p>
            <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne">✔️ Recevez jusqu'à 10 000€ de
                subventions en 72h</p>
        </div>
        <div class="h-14 md:h-15 px-8 py-2.5 bg-[#013565] rounded inline-flex justify-center items-center gap-3">
            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12.6402 13.175C12.8682 12.985 13 12.7035 13 12.4068C13 12.11 12.8682 11.8285 12.6402 11.6385L6.64018 6.63854C6.2159 6.28498 5.58534 6.3423 5.23177 6.76658C4.87821 7.19086 4.93553 7.82142 5.35981 8.17498L10.4379 12.4068L5.35981 16.6385C4.93553 16.9921 4.87821 17.6227 5.23177 18.0469C5.58534 18.4712 6.2159 18.5285 6.64018 18.175L12.6402 13.175Z"
                    fill="white" />
                <path opacity="0.5"
                    d="M18.6402 13.175C18.8682 12.985 19 12.7035 19 12.4068C19 12.11 18.8682 11.8285 18.6402 11.6385L12.6402 6.63854C12.2159 6.28498 11.5853 6.3423 11.2318 6.76658C10.8782 7.19086 10.9355 7.82142 11.3598 8.17498L16.4379 12.4068L11.3598 16.6385C10.9355 16.9921 10.8782 17.6227 11.2318 18.0469C11.5853 18.4712 12.2159 18.5285 12.6402 18.175L18.6402 13.175Z"
                    fill="white" />
            </svg>
            <a href="{{ route('form') }}" class="text-right text-white text-lg font-bold font-marianne uppercase">vérifier mes droits</a>
            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M11.3598 11.6385C11.1318 11.8285 11 12.1099 11 12.4067C11 12.7035 11.1318 12.9849 11.3598 13.1749L17.3598 18.1749C17.7841 18.5285 18.4146 18.4712 18.7682 18.0469C19.1218 17.6226 19.0644 16.9921 18.6402 16.6385L13.562 12.4067L18.6402 8.17493C19.0644 7.82137 19.1218 7.19081 18.7682 6.76653C18.4146 6.34225 17.7841 6.28493 17.3598 6.63849L11.3598 11.6385Z"
                    fill="white" />
                <path opacity="0.5"
                    d="M5.35979 11.6385C5.1318 11.8285 4.99998 12.1099 4.99998 12.4067C4.99998 12.7035 5.1318 12.9849 5.35979 13.1749L11.3598 18.1749C11.7841 18.5285 12.4146 18.4712 12.7682 18.0469C13.1218 17.6226 13.0644 16.9921 12.6402 16.6385L7.56203 12.4067L12.6402 8.17493C13.0644 7.82137 13.1218 7.19081 12.7682 6.76653C12.4146 6.34225 11.7841 6.28493 11.3598 6.63849L5.35979 11.6385Z"
                    fill="white" />
            </svg>
        </div>
    </div>
</div>
