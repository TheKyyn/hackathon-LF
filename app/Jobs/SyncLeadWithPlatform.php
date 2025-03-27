<?php

namespace App\Jobs;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SyncLeadWithPlatform implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $lead;

    /**
     * Crée une nouvelle instance du job.
     */
    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    /**
     * Exécute le job.
     */
    public function handle(): void
    {
        try {
            $centralPlatformUrl = config('services.central_platform.url');
            $apiToken = config('services.central_platform.api_token');

            if (!$centralPlatformUrl || !$apiToken) {
                Log::error('Configuration de la plateforme centrale manquante');
                return;
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiToken,
                'Accept' => 'application/json',
            ])->post($centralPlatformUrl . '/api/leads/sync', $this->lead->toArray());

            if ($response->successful()) {
                Log::info('Lead #' . $this->lead->id . ' synchronisé avec succès');
            } else {
                Log::warning('Échec de la synchronisation du lead #' . $this->lead->id . ' avec la plateforme centrale. Code: ' . $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de la synchronisation du lead #' . $this->lead->id . ' avec la plateforme centrale: ' . $e->getMessage());

            // En cas d'échec, nous pouvons réessayer (avec un délai)
            if ($this->attempts() < 3) {
                $this->release(30 * $this->attempts());
            }
        }
    }
}
