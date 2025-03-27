<div class="w-full flex flex-col">
    <div class="w-full text-center py-2 bg-gray-50">
        <div class="text-[#ababab] text-xs font-normal font-marianne uppercase">publi-reportage</div>
    </div>

    <div class="w-screen relative left-1/2 right-1/2 -mx-[50vw] my-0">
        <img src="{{ asset('images/landing/imgs/main-solar-img.png') }}" alt="Panneaux solaires"
            class="w-full h-auto object-cover" />
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-6">
            <div class="px-6 py-3 bg-[#013565] rounded text-white text-sm font-medium font-marianne uppercase">
                annonce importante
            </div>

            <div class="flex items-center gap-3">
                <img class="w-10 h-10 rounded-full" src="{{ asset('images/landing/imgs/arthur-hackathon.jpeg') }}"
                    alt="Photo auteur" />
                <div class="flex flex-col">
                    <div class="text-gray-600 text-xs font-marianne">Auteur : Arthur Lafont</div>
                    <div class="text-gray-600 text-xs font-marianne">Publié: il y a 2h</div>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-4 font-marianne">Obtenez vos panneaux solaires sans payer
                l'installation si vous vivez dans une zone éligible</h1>
            <p class="text-xl text-black font-normal font-marianne">Avec la flambée des prix de l'énergie, l'État a enfin décidé
                d'agir en lançant un programme exceptionnel pour aider les propriétaires à équiper leur maison en
                panneaux solaires : Le Plan Solaire 2025.</p>
        </div>

        {{-- <div class="mb-4">
            <a href="{{ route('form') }}"
                class="inline-flex items-center px-6 py-4 bg-[#41b99f] hover:bg-[#3aa48c] text-white font-bold rounded-lg shadow-lg transition-colors duration-300">
                <span>Vérifier mon éligibilité gratuitement</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        </div> --}}

        <div class="mb-8">
            <a href="https://www.francetvinfo.fr/environnement/energie/" target="_blank" rel="noopener noreferrer"
                class="px-5 py-3 bg-[#41b99f] rounded-full inline-flex items-center gap-2 text-white text-sm font-marianne">
                <span class="uppercase">Vérifiez si vous êtes éligible sur le site officiel franceinfoénergie.fr</span>
                <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.5 3.5C10.5 3.91421 10.8358 4.25 11.25 4.25H13.1893L8.46967 8.96967C8.17678 9.26256 8.17678 9.73744 8.46967 10.0303C8.76256 10.3232 9.23744 10.3232 9.53033 10.0303L14.25 5.31066V7.25C14.25 7.66421 14.5858 8 15 8C15.4142 8 15.75 7.66421 15.75 7.25V3.5C15.75 3.08579 15.4142 2.75 15 2.75H11.25C10.8358 2.75 10.5 3.08579 10.5 3.5Z"
                        fill="white" />
                    <path opacity="0.5"
                        d="M5.25 2.75C3.59315 2.75 2.25 4.09315 2.25 5.75V13.25C2.25 14.9069 3.59315 16.25 5.25 16.25H12.75C14.4069 16.25 15.75 14.9069 15.75 13.25V10.25C15.75 9.83579 15.4142 9.5 15 9.5C14.5858 9.5 14.25 9.83579 14.25 10.25V13.25C14.25 14.0784 13.5784 14.75 12.75 14.75H5.25C4.42157 14.75 3.75 14.0784 3.75 13.25V5.75C3.75 4.92157 4.42157 4.25 5.25 4.25H8.25C8.66421 4.25 9 3.91421 9 3.5C9 3.08579 8.66421 2.75 8.25 2.75H5.25Z"
                        fill="white" />
                </svg>
            </a>
        </div>

        <!-- Image banner-solaire-linky-maison.png ajoutée en dessous du bouton -->
        <div class="w-full mt-4">
            <img src="{{ asset('images/landing/imgs/banner-solaire-linky-maison.png') }}" alt="Panneaux solaires sur maison" class="w-full h-auto rounded-lg" />
        </div>
    </div>
</div>
