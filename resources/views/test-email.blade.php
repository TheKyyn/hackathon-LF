<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test d'envoi d'Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">Test d'envoi d'Email</h1>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="h5 mb-0">Diagnostic configuration email</h3>
            </div>
            <div class="card-body">
                <p>Vérifiez la configuration SMTP actuelle de votre application :</p>
                <button id="checkConfig" class="btn btn-info">Vérifier la configuration</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h3 class="h5 mb-0">Tester avec Laravel</h3>
                    </div>
                    <div class="card-body">
                        <p>Envoyer un email de test en utilisant la configuration Laravel :</p>
                        <form id="testEmailForm" action="/test-email" method="get">
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-success">Envoyer un email de test</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h3 class="h5 mb-0">Tester avec PHP mail()</h3>
                    </div>
                    <div class="card-body">
                        <p>Envoyer un email en utilisant la fonction PHP mail() native (contourne Laravel) :</p>
                        <form id="testNativeMailForm" action="/test-native-mail" method="get">
                            <div class="mb-3">
                                <label for="native_email" class="form-label">Adresse email</label>
                                <input type="email" class="form-control" id="native_email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-warning">Tester avec mail() PHP</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h3 class="h5 mb-0">Résultats</h3>
                    </div>
                    <div class="card-body">
                        <div id="results" class="border p-3 bg-light">
                            <p class="text-muted">Les résultats des tests apparaîtront ici...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fonction pour afficher les résultats
            function displayResults(data, isError = false) {
                const resultsDiv = document.getElementById('results');
                let html = '';

                if (isError) {
                    html = `<div class="alert alert-danger">${data}</div>`;
                } else {
                    html = `<div class="alert alert-success">Opération réussie</div>`;
                    html += `<pre class="mt-3 bg-dark text-white p-3 rounded">${JSON.stringify(data, null, 2)}</pre>`;
                }

                resultsDiv.innerHTML = html;
            }

            // Configuration
            document.getElementById('checkConfig').addEventListener('click', function(e) {
                e.preventDefault();

                fetch('/test-email-config')
                    .then(response => response.json())
                    .then(data => {
                        displayResults(data);
                    })
                    .catch(error => {
                        displayResults(`Erreur: ${error.message}`, true);
                    });
            });

            // Formulaire email Laravel
            document.getElementById('testEmailForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const email = document.getElementById('email').value;

                fetch(`/test-email?email=${encodeURIComponent(email)}`)
                    .then(response => response.json())
                    .then(data => {
                        displayResults(data);
                    })
                    .catch(error => {
                        displayResults(`Erreur: ${error.message}`, true);
                    });
            });

            // Formulaire email PHP natif
            document.getElementById('testNativeMailForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const email = document.getElementById('native_email').value;

                fetch(`/test-native-mail?email=${encodeURIComponent(email)}`)
                    .then(response => response.json())
                    .then(data => {
                        displayResults(data);
                    })
                    .catch(error => {
                        displayResults(`Erreur: ${error.message}`, true);
                    });
            });
        });
    </script>
</body>
</html>
