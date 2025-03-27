<?php

/*
|--------------------------------------------------------------------------
| Test Manuel de la Synchronisation des Leads
|--------------------------------------------------------------------------
|
| Ce script vous permet de tester manuellement la synchronisation des leads
| entre le site de collecte et la plateforme centrale.
|
| Exécutez ce script avec:
| $ php tests/manual_sync_test.php
|
*/

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Lead;
use Illuminate\Support\Facades\Log;

// Configuration du test
echo "=== CONFIGURATION DU TEST ===\n";
$apiToken = config('services.central_platform.api_token');
$apiUrl = config('services.central_platform.url');

echo "URL de la plateforme centrale: {$apiUrl}\n";
echo "Token API configuré: " . ($apiToken ? 'Oui' : 'Non') . "\n";

if (!$apiToken || !$apiUrl) {
    echo "ERREUR: Configuration manquante. Veuillez vérifier votre .env\n";
    exit(1);
}

// 1. Créer un lead de test
echo "\n=== CRÉATION D'UN LEAD DE TEST ===\n";
$lead = new Lead();
$lead->first_name = 'Test_' . uniqid();
$lead->last_name = 'Sync';
$lead->email = 'test.' . uniqid() . '@example.com';
$lead->phone = '0601020304';
$lead->address = '123 Rue de Test';
$lead->postal_code = '75001';
$lead->city = 'Paris';
$lead->energy_type = 'pompe_a_chaleur';
$lead->property_type = 'maison_individuelle';
$lead->is_owner = true;
$lead->has_project = true;
$lead->optin = true;
$lead->status = 'new';
$lead->save();

echo "Lead #{$lead->id} créé: {$lead->first_name} {$lead->last_name}\n";

// 2. Tester la synchronisation directe
echo "\n=== TEST DE SYNCHRONISATION DIRECTE ===\n";
try {
    $startTime = microtime(true);
    $result = $lead->syncWithCentralPlatform();
    $endTime = microtime(true);

    if ($result) {
        echo "SUCCÈS: Lead synchronisé en " . round(($endTime - $startTime) * 1000) . " ms\n";
    } else {
        echo "ÉCHEC: La synchronisation a échoué\n";
    }
} catch (\Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}

// 3. Tester la commande artisan
echo "\n=== TEST DE LA COMMANDE ARTISAN ===\n";
try {
    $exitCode = Artisan::call('leads:sync-platform', ['--id' => $lead->id]);
    $output = Artisan::output();

    echo $output;
    echo "Code de sortie: {$exitCode}\n";
} catch (\Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}

// 4. Tester la mise à jour du lead
echo "\n=== TEST DE MISE À JOUR DU LEAD ===\n";
try {
    $lead->status = 'contacted';
    $lead->comment = 'Mise à jour de test ' . date('Y-m-d H:i:s');
    $lead->save();

    echo "Lead #{$lead->id} mis à jour\n";

    // Vérifier que l'observer est appelé en vérifiant les logs
    echo "Vérifiez les logs pour confirmer que LeadObserver::updated a été appelé\n";
} catch (\Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}

echo "\n=== TEST MANUEL TERMINÉ ===\n";
echo "Vérifiez la plateforme centrale pour confirmer que le lead a bien été reçu\n";
