<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Calendly Webhook</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-3xl mx-auto bg-white rounded shadow p-6">
        <h1 class="text-2xl font-bold mb-6">Test Calendly Webhook</h1>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Configuration</h2>
            <p class="mb-2">L'URL de votre webhook Calendly est :</p>
            <div class="bg-gray-200 p-3 rounded mb-4 font-mono">
                {{ url('/calendly/webhook') }}
            </div>
            <p class="text-sm text-gray-600 mb-4">
                Assurez-vous que cette URL est accessible depuis l'extérieur si vous utilisez un webhook réel.
                Pour les tests locaux, vous pouvez utiliser le formulaire ci-dessous.
            </p>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Méthode alternative (plus fiable)</h2>
            <p class="mb-2">Si le formulaire ne fonctionne pas, utilisez cette méthode alternative :</p>
            <div class="mt-4">
                <form action="{{ url('/test-calendly-webhook') }}" method="GET" class="mt-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="email-alt">Email du lead :</label>
                        <input type="email" id="email-alt" name="email" class="w-full p-2 border rounded"
                               placeholder="email@example.com" required>
                    </div>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">
                        Tester directement (Méthode GET)
                    </button>
                </form>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Simulation de webhook</h2>
            <p class="mb-2">Utilisez ce formulaire pour simuler un webhook Calendly :</p>

            <form id="webhookForm" class="mt-4">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="email">Email du lead :</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border rounded"
                           placeholder="email@example.com" required>
                    <p class="text-sm text-gray-600 mt-1">
                        Utilisez l'email d'un lead existant dans votre base de données
                    </p>
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                    Simuler le webhook
                </button>
            </form>

            <div id="result" class="mt-6 hidden">
                <h3 class="font-semibold mb-2">Résultat :</h3>
                <pre id="resultContent" class="bg-gray-200 p-3 rounded whitespace-pre-wrap"></pre>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('webhookForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const now = new Date();
            const startTime = new Date(now.getTime() + 24 * 60 * 60 * 1000).toISOString(); // 24h dans le futur

            const payload = {
                event: 'invitee.created',
                payload: {
                    invitee: {
                        email: email,
                        uuid: 'test-' + Date.now()
                    },
                    event: {
                        start_time: startTime
                    }
                }
            };

            const resultElement = document.getElementById('result');
            const resultContentElement = document.getElementById('resultContent');

            resultElement.classList.remove('hidden');
            resultContentElement.textContent = "Envoi de la requête en cours...";

            fetch('{{ url("/calendly/webhook") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`Erreur HTTP ${response.status}: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                resultElement.classList.remove('hidden');
                resultContentElement.textContent = JSON.stringify(data, null, 2);

                if (data.status === 'success') {
                    resultElement.classList.add('text-green-600');
                    resultElement.classList.remove('text-red-600');
                } else {
                    resultElement.classList.add('text-red-600');
                    resultElement.classList.remove('text-green-600');
                }
            })
            .catch(error => {
                resultElement.classList.remove('hidden');
                resultElement.classList.add('text-red-600');
                resultContentElement.textContent = 'Erreur : ' + error.message;

                console.error('Erreur complète:', error);
            });
        });
    </script>
</body>
</html>
