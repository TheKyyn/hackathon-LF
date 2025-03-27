<div class="w-screen relative left-1/2 right-1/2 -mx-[50vw] bg-gray-100 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Titre aligné à gauche -->
        <h2 class="text-black text-xl md:text-2xl lg:text-3xl font-bold font-marianne mb-6">
            {{ $landing->getValueOrDefault('map_title', 'Nous intervenons dans toute la France') }}
        </h2>

        <!-- Sous-titre -->
        <p class="text-gray-700 mb-8">
            {{ $landing->getValueOrDefault('map_subtitle', 'Notre réseau d\'installateurs agréés couvre l\'ensemble du territoire français pour vous garantir un service de proximité optimal.') }}
        </p>

        <!-- Carte de France simplifiée -->
        <div class="w-full h-64 md:h-96 bg-white rounded-lg shadow-md flex justify-center items-center">
            <div class="text-center p-4">
                <svg class="w-full h-full max-w-md mx-auto" viewBox="0 0 800 800" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Version simplifiée de la carte de France -->
                    <path d="M400,100 Q550,150 600,300 Q650,450 550,600 Q450,750 300,700 Q150,650 100,500 Q50,350 150,200 Q250,50 400,100 Z"
                          fill="#e3f2fd"
                          stroke="#1565c0"
                          stroke-width="8"/>
                    <!-- Points représentant les grandes villes -->
                    <circle cx="400" cy="250" r="12" fill="#f44336"/> <!-- Paris -->
                    <circle cx="200" cy="300" r="8" fill="#f44336"/> <!-- Brest -->
                    <circle cx="300" cy="600" r="8" fill="#f44336"/> <!-- Bordeaux -->
                    <circle cx="500" cy="650" r="8" fill="#f44336"/> <!-- Marseille -->
                    <circle cx="550" cy="350" r="8" fill="#f44336"/> <!-- Strasbourg -->
                    <circle cx="450" cy="450" r="8" fill="#f44336"/> <!-- Lyon -->
                </svg>
            </div>
        </div>

        <!-- Texte en dessous de la carte -->
        <div class="mt-6 text-center">
            <p class="text-lg font-medium">
                {{ $landing->getValueOrDefault('map_footer_text', 'Vérifiez votre éligibilité dès maintenant, où que vous soyez en France !') }}
            </p>
        </div>
    </div>
</div>
