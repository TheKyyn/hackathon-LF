<?php

namespace App\Console\Commands;

use App\Models\Lead;
use App\Services\EmailService;
use App\Services\TwilioService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckCalendlyAppointments extends Command
{
    protected $signature = 'calendly:check-appointments {--hours=1 : Vérifier les rendez-vous des dernières X heures}';
    protected $description = 'Vérifie les nouveaux rendez-vous Calendly et envoie des confirmations';

    protected $emailService;
    protected $twilioService;
    protected $apiKey;
    protected $baseUrl = 'https://api.calendly.com';

    public function __construct(EmailService $emailService, TwilioService $twilioService)
    {
        parent::__construct();
        $this->emailService = $emailService;
        $this->twilioService = $twilioService;
        $this->apiKey = env('CALENDLY_API_KEY');

        if (!$this->apiKey) {
            Log::error('Clé API Calendly non configurée');
        }
    }

    public function handle()
    {
        if (!$this->apiKey) {
            $this->error('Clé API Calendly non configurée. Veuillez définir CALENDLY_API_KEY dans le fichier .env');
            return 1;
        }

        $hours = $this->option('hours');
        $this->info("Vérification des rendez-vous Calendly des {$hours} dernières heures...");

        try {
            // Récupérer les informations de l'utilisateur Calendly
            $userResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/users/me');

            if (!$userResponse->successful()) {
                $this->error('Erreur lors de la récupération des informations utilisateur Calendly');
                Log::error('Erreur lors de la récupération des informations utilisateur Calendly', [
                    'status' => $userResponse->status(),
                    'response' => $userResponse->body()
                ]);
                return 1;
            }

            $userData = $userResponse->json();
            $userUri = $userData['resource']['uri'] ?? null;

            if (!$userUri) {
                $this->error('URI utilisateur Calendly non trouvé');
                return 1;
            }

            // Définir l'intervalle de temps pour les rendez-vous à vérifier
            $minTime = Carbon::now()->subHours($hours)->toIso8601String();
            $maxTime = Carbon::now()->toIso8601String();

            // Récupérer les événements de l'utilisateur
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
                $this->error('Erreur lors de la récupération des événements Calendly');
                Log::error('Erreur lors de la récupération des événements Calendly', [
                    'status' => $eventsResponse->status(),
                    'response' => $eventsResponse->body()
                ]);
                return 1;
            }

            $eventsData = $eventsResponse->json();
            $events = $eventsData['collection'] ?? [];

            if (empty($events)) {
                $this->info('Aucun événement trouvé dans l\'intervalle de temps spécifié.');
                return 0;
            }

            $this->info(count($events) . ' événement(s) trouvé(s).');

            $processedCount = 0;
            $errorCount = 0;

            // Pour chaque événement, récupérer les invités
            foreach ($events as $event) {
                $eventUri = $event['uri'] ?? null;
                if (!$eventUri) {
                    continue;
                }

                $inviteesResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json'
                ])->get($this->baseUrl . '/scheduled_events/' . basename($eventUri) . '/invitees');

                if (!$inviteesResponse->successful()) {
                    $this->error('Erreur lors de la récupération des invités pour l\'événement ' . basename($eventUri));
                    Log::error('Erreur lors de la récupération des invités', [
                        'event_uri' => $eventUri,
                        'status' => $inviteesResponse->status(),
                        'response' => $inviteesResponse->body()
                    ]);
                    continue;
                }

                $inviteesData = $inviteesResponse->json();
                $invitees = $inviteesData['collection'] ?? [];

                foreach ($invitees as $invitee) {
                    $email = $invitee['email'] ?? null;
                    $createdAt = $invitee['created_at'] ?? null;

                    // Ne traiter que les invités créés dans l'intervalle spécifié
                    if (!$email || !$createdAt) {
                        continue;
                    }

                    $createdAtTime = Carbon::parse($createdAt);
                    if ($createdAtTime->lt(Carbon::now()->subHours($hours))) {
                        continue;
                    }

                    $this->info("Traitement de l'invité: {$email}");

                    // Rechercher le lead correspondant
                    $lead = Lead::where('email', $email)->first();
                    if (!$lead) {
                        $this->warn("Aucun lead trouvé pour l'email: {$email}");
                        continue;
                    }

                    try {
                        // Vérifier si l'email de confirmation a déjà été envoyé
                        if ($lead->appointment_date && strtotime($lead->appointment_date) == strtotime($event['start_time'])) {
                            $this->info("Le lead {$email} a déjà un rendez-vous enregistré à cette date.");

                            // Si le statut n'est pas déjà "appointment_scheduled", mettre à jour et envoyer l'email
                            if ($lead->status !== 'appointment_scheduled') {
                                $lead->status = 'appointment_scheduled';
                                $lead->save();

                                // Envoyer l'email et le SMS
                                $emailSent = $this->emailService->sendAppointmentConfirmation($lead, $event['start_time']);
                                $smsSent = $this->twilioService->sendAppointmentConfirmation($lead, $event['start_time']);

                                $this->info("Email envoyé: " . ($emailSent ? 'Oui' : 'Non'));
                                $this->info("SMS envoyé: " . ($smsSent ? 'Oui' : 'Non'));

                                if ($emailSent || $smsSent) {
                                    $processedCount++;
                                }
                            } else {
                                $this->info("Le lead a déjà le statut 'appointment_scheduled'.");

                                // Vérifier si l'email a déjà été envoyé
                                if (!$lead->email_sent) {
                                    $emailSent = $this->emailService->sendAppointmentConfirmation($lead, $event['start_time']);
                                    $this->info("Email de rattrapage envoyé: " . ($emailSent ? 'Oui' : 'Non'));

                                    if ($emailSent) {
                                        $lead->email_sent = true;
                                        $lead->save();
                                        $processedCount++;
                                    }
                                }
                            }
                        } else {
                            // Mettre à jour les informations du rendez-vous
                            $lead->appointment_date = $event['start_time'];
                            $lead->appointment_id = 'cal-' . basename($eventUri);
                            $lead->status = 'appointment_scheduled';
                            $lead->email_sent = false;
                            $lead->save();

                            $this->info("Rendez-vous enregistré pour le lead {$email}");

                            // Envoyer l'email et le SMS
                            $emailSent = $this->emailService->sendAppointmentConfirmation($lead, $event['start_time']);
                            $smsSent = $this->twilioService->sendAppointmentConfirmation($lead, $event['start_time']);

                            $this->info("Email envoyé: " . ($emailSent ? 'Oui' : 'Non'));
                            $this->info("SMS envoyé: " . ($smsSent ? 'Oui' : 'Non'));

                            if ($emailSent) {
                                $lead->email_sent = true;
                                $lead->save();
                            }

                            if ($emailSent || $smsSent) {
                                $processedCount++;
                            } else {
                                $errorCount++;
                            }
                        }
                    } catch (\Exception $e) {
                        $this->error("Exception lors du traitement de l'invité {$email}: " . $e->getMessage());
                        Log::error("Exception lors du traitement de l'invité Calendly", [
                            'email' => $email,
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        $errorCount++;
                    }
                }
            }

            $this->info("Traitement terminé: $processedCount rendez-vous traités, $errorCount erreurs.");
            return 0;
        } catch (\Exception $e) {
            $this->error('Exception: ' . $e->getMessage());
            Log::error('Exception lors de la vérification des rendez-vous Calendly', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }
}
