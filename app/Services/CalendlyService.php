<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CalendlyService
{
    protected $apiKey;
    protected $calendlyUrl;
    protected $baseUrl = 'https://api.calendly.com';

    public function __construct()
    {
        $this->apiKey = env('CALENDLY_API_KEY');
        $this->calendlyUrl = env('CALENDLY_URL');

        if (!$this->apiKey) {
            Log::error('Clé API Calendly non configurée');
        }
    }

    /**
     * Récupère les rendez-vous récents (dernières 24h)
     *
     * @return array
     */
    public function getRecentAppointments(): array
    {
        try {
            // Extraire l'UUID de l'utilisateur Calendly depuis l'URL
            $urlParts = explode('/', $this->calendlyUrl);
            $username = end($urlParts);

            // Récupérer les informations de l'utilisateur
            $userResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/users/me');

            if (!$userResponse->successful()) {
                Log::error('Erreur lors de la récupération des informations utilisateur Calendly', [
                    'status' => $userResponse->status(),
                    'response' => $userResponse->body()
                ]);
                return [];
            }

            $userData = $userResponse->json();
            $userUri = $userData['resource']['uri'] ?? null;

            if (!$userUri) {
                Log::error('URI utilisateur Calendly non trouvé');
                return [];
            }

            // Récupérer les événements de l'utilisateur
            $minTime = now()->subDay()->toISOString();
            $eventsResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/scheduled_events', [
                'user' => $userUri,
                'min_start_time' => $minTime,
                'status' => 'active'
            ]);

            if (!$eventsResponse->successful()) {
                Log::error('Erreur lors de la récupération des événements Calendly', [
                    'status' => $eventsResponse->status(),
                    'response' => $eventsResponse->body()
                ]);
                return [];
            }

            $events = $eventsResponse->json()['collection'] ?? [];
            $appointments = [];

            foreach ($events as $event) {
                $eventUri = $event['uri'];

                // Récupérer les invités pour cet événement
                $inviteesResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json'
                ])->get($this->baseUrl . '/scheduled_events/' . basename($eventUri) . '/invitees');

                if (!$inviteesResponse->successful()) {
                    Log::warning('Erreur lors de la récupération des invités pour un événement', [
                        'event_uri' => $eventUri,
                        'status' => $inviteesResponse->status()
                    ]);
                    continue;
                }

                $invitees = $inviteesResponse->json()['collection'] ?? [];

                foreach ($invitees as $invitee) {
                    $appointments[] = [
                        'event' => $event,
                        'invitee' => $invitee
                    ];
                }
            }

            return $appointments;
        } catch (\Exception $e) {
            Log::error('Exception lors de la récupération des rendez-vous Calendly: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
    }

    /**
     * Récupère les rendez-vous à venir dans les prochaines 24h
     *
     * @return array
     */
    public function getUpcomingAppointments(): array
    {
        try {
            // Extraire l'UUID de l'utilisateur Calendly depuis l'URL
            $urlParts = explode('/', $this->calendlyUrl);
            $username = end($urlParts);

            // Récupérer les informations de l'utilisateur
            $userResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/users/me');

            if (!$userResponse->successful()) {
                Log::error('Erreur lors de la récupération des informations utilisateur Calendly', [
                    'status' => $userResponse->status(),
                    'response' => $userResponse->body()
                ]);
                return [];
            }

            $userData = $userResponse->json();
            $userUri = $userData['resource']['uri'] ?? null;

            if (!$userUri) {
                Log::error('URI utilisateur Calendly non trouvé');
                return [];
            }

            // Récupérer les événements prévus dans 24-36h (pour envoyer des rappels 24h avant)
            $minTime = now()->addHours(24)->toISOString();
            $maxTime = now()->addHours(36)->toISOString();

            $eventsResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/scheduled_events', [
                'user' => $userUri,
                'min_start_time' => $minTime,
                'max_start_time' => $maxTime,
                'status' => 'active'
            ]);

            if (!$eventsResponse->successful()) {
                Log::error('Erreur lors de la récupération des événements à venir Calendly', [
                    'status' => $eventsResponse->status(),
                    'response' => $eventsResponse->body()
                ]);
                return [];
            }

            $events = $eventsResponse->json()['collection'] ?? [];
            $appointments = [];

            foreach ($events as $event) {
                $eventUri = $event['uri'];

                // Récupérer les invités pour cet événement
                $inviteesResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json'
                ])->get($this->baseUrl . '/scheduled_events/' . basename($eventUri) . '/invitees');

                if (!$inviteesResponse->successful()) {
                    Log::warning('Erreur lors de la récupération des invités pour un événement à venir', [
                        'event_uri' => $eventUri,
                        'status' => $inviteesResponse->status()
                    ]);
                    continue;
                }

                $invitees = $inviteesResponse->json()['collection'] ?? [];

                foreach ($invitees as $invitee) {
                    $appointments[] = [
                        'event' => $event,
                        'invitee' => $invitee
                    ];
                }
            }

            return $appointments;
        } catch (\Exception $e) {
            Log::error('Exception lors de la récupération des rendez-vous à venir Calendly: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
    }
}
