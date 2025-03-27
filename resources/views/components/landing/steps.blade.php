<!-- Fond pleine largeur avec contenu centré -->
<div class="w-screen relative left-1/2 right-1/2 -mx-[50vw] bg-[#fbfbfb] py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="w-full flex flex-col justify-start items-start gap-6">
            <!-- Titre aligné à gauche -->
            <h2 class="text-black text-xl md:text-2xl lg:text-[26px] font-bold font-marianne">Comment vérifier si vous êtes éligible ?</h2>
            <div class="w-full flex flex-col justify-start items-start gap-4">
                <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne">
                    Le dispositif de FranceInfoénergie vous propose une solution en ligne pour simplifier vos démarches et vérifier votre éligibilité.
                </p>
                <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne">
                    Voici les trois étapes à suivre :
                </p>
            </div>
        </div>
        <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
            <div class="flex flex-col justify-start items-start gap-6">
                <div class="flex flex-col justify-start items-start gap-2">
                    <div class="text-black text-4xl md:text-5xl font-bold font-marianne">1.</div>
                    <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne">
                        Sélectionnez votre région sur la carte ci-dessous et répondez à quelques questions.
                    </p>
                </div>
                <a href="{{ route('form') }}" class="w-full h-14 md:h-15 px-8 py-2.5 bg-[#013565] hover:bg-[#01294e] rounded border border-[#013565] inline-flex justify-center items-center gap-3 transition-colors duration-300">
                    <div class="text-right text-white text-lg font-bold font-marianne uppercase">vérifier mes droits</div>
                </a>
            </div>
            <div class="flex flex-col justify-start items-start gap-2">
                <div class="text-black text-4xl md:text-5xl font-bold font-marianne">2.</div>
                <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne">
                    Recevez un document avec vos aides disponibles ainsi que les coûts des travaux.
                </p>
            </div>
            <div class="flex flex-col justify-start items-start gap-2">
                <div class="text-black text-4xl md:text-5xl font-bold font-marianne">3.</div>
                <p class="text-black text-base md:text-lg lg:text-xl font-normal font-marianne">
                    Si vous le souhaitez, un expert en énergie solaire vous contacte afin de discuter de votre projet.
                </p>
            </div>
        </div>
    </div>
</div>
