<?php

namespace Tests\Unit;

use App\Jobs\SyncLeadWithPlatform;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SyncLeadWithPlatformJobTest extends TestCase
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
    }

    /**
     * Teste si le job est correctement mis en file d'attente.
     */
    public function test_job_is_pushed_to_queue(): void
    {
        // Activer le faux système de file d'attente
        Queue::fake();

        // Créer un lead de test
        $lead = Lead::factory()->create();

        // Dispatcher le job
        SyncLeadWithPlatform::dispatch($lead);

        // Vérifier que le job a été poussé dans la file d'attente
        Queue::assertPushed(SyncLeadWithPlatform::class, function ($job) use ($lead) {
            return $job->lead->id === $lead->id;
        });
    }

    /**
     * Teste si le job traite correctement la synchronisation.
     */
    public function test_job_processes_lead_synchronization(): void
    {
        // Créer un lead de test
        $lead = Lead::factory()->create([
            'first_name' => 'Marie',
            'last_name' => 'Dubois',
            'email' => 'marie.dubois@example.com',
        ]);

        // Créer une instance du job
        $job = new SyncLeadWithPlatform($lead);

        // Mock la méthode syncWithPlatform du lead
        $mockLead = $this->createMock(Lead::class);
        $mockLead->expects($this->once())
                 ->method('syncWithPlatform')
                 ->willReturn(true);

        // Remplacer le lead du job par notre mock
        $reflectionClass = new \ReflectionClass($job);
        $property = $reflectionClass->getProperty('lead');
        $property->setAccessible(true);
        $property->setValue($job, $mockLead);

        // Exécuter le job
        $job->handle();
    }
}
