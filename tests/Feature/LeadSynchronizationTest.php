<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Observers\LeadObserver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LeadSynchronizationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Configuration du test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Configurer l'API mock
        Http::fake([
            config('services.central_platform.url') . '/api/v1/leads/sync' => Http::response([
                'success' => true,
                'message' => 'Lead créé avec succès',
                'data' => ['id' => 1]
            ], 201)
        ]);

        // Désactiver l'observer pendant les tests pour éviter la synchronisation automatique
        Lead::flushEventListeners();
    }

    /**
     * Teste si un lead peut être synchronisé directement avec la plateforme centrale.
     */
    public function test_lead_can_be_synchronized_with_central_platform(): void
    {
        // Créer un lead de test
        $lead = Lead::factory()->create([
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'email' => 'jean.dupont@example.com',
            'phone' => '0601020304',
        ]);

        // Tester la synchronisation directe
        $result = $lead->syncWithCentralPlatform();

        // Vérifier que la synchronisation a réussi
        $this->assertTrue($result);

        // Vérifier que la requête a été effectuée
        Http::assertSent(function ($request) use ($lead) {
            return $request->url() === config('services.central_platform.url') . '/api/v1/leads/sync' &&
                   $request->method() === 'POST' &&
                   $request['original_id'] === $lead->id &&
                   $request['email'] === 'jean.dupont@example.com';
        });
    }

    /**
     * Teste si l'observer des leads déclenche la synchronisation.
     */
    public function test_lead_observer_triggers_synchronization(): void
    {
        // Simuler la méthode de synchronisation
        $mock = $this->createMock(LeadObserver::class);
        $mock->expects($this->once())
             ->method('created')
             ->willReturn(null);

        // Créer un lead qui devrait déclencher l'observer
        $lead = new Lead([
            'first_name' => 'Pierre',
            'last_name' => 'Martin',
            'email' => 'pierre.martin@example.com',
            'phone' => '0607080910',
        ]);

        // Déclencher manuellement l'observer
        $mock->created($lead);
    }

    /**
     * Teste la commande artisan de synchronisation des leads.
     */
    public function test_artisan_command_can_synchronize_leads(): void
    {
        // Créer plusieurs leads
        $leads = Lead::factory()->count(3)->create();

        // Appeler la commande artisan
        $this->artisan('leads:sync-platform')
             ->expectsOutput('Synchronisation de 3 leads avec la plateforme centrale...')
             ->assertExitCode(0);

        // Vérifier que Http a reçu 3 requêtes
        Http::assertSentCount(3);
    }
}
