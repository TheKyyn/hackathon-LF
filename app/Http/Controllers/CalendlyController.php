<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\TwilioService;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class CalendlyController extends Controller
{
    protected $twilioService;
    protected $emailService;
    protected $calendlyApiKey;
    protected $calendlyUrl;

    /**
     * Initialise le contrôleur avec les services nécessaires
     */
    public function __construct(TwilioService $twilioService, EmailService $emailService)
    {
        $this->twilioService = $twilioService;
        $this->emailService = $emailService;
        $this->calendlyApiKey = env('CALENDLY_API_KEY');
        $this->calendlyUrl = env('CALENDLY_URL', 'https://calendly.com/la-factory-lead');
    }

    /**
     * Affiche la page de prise de rendez-vous Calendly.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        $leadId = $request->input('lead_id');
        $lead = Lead::findOrFail($leadId);

        return view('calendly', [
            'lead' => $lead,
            'calendlyUrl' => $this->calendlyUrl
        ]);
    }

    /**
     * Traitement du webhook Calendly.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function webhook(Request $request)
    {
        // Écrire immédiatement un fichier de trace pour vérifier que le webhook est appelé
        $debugFilePath = storage_path('logs/calendly_webhook_debug_' . date('Y-m-d_H-i-s') . '.txt');
        File::put($debugFilePath, "Webhook reçu à " . date('Y-m-d H:i:s') . "\n" .
                               "IP: " . $request->ip() . "\n" .
                               "Contenu: " . substr($request->getContent(), 0, 2000));

        try {
            // Ajouter des logs détaillés pour le débogage
            Log::info('🔴 WEBHOOK CALENDLY REÇU', [
                'timestamp' => date('Y-m-d H:i:s'),
                'ip' => $request->ip(),
                'debug_file' => $debugFilePath
            ]);

            // Récupérer et loguer l'IP source et les en-têtes
            Log::debug('Webhook Calendly - Informations de la requête', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'content_type' => $request->header('Content-Type'),
                'accept' => $request->header('Accept'),
                'method' => $request->method(),
                'all_headers' => $request->headers->all()
            ]);

            // Récupérer les données brutes
            $rawPayload = $request->getContent();
            Log::debug('Webhook Calendly - Données brutes reçues', [
                'content_length' => strlen($rawPayload),
                'raw_payload' => substr($rawPayload, 0, 1000) . (strlen($rawPayload) > 1000 ? '...' : '')
            ]);

            // Vérifier si le payload est du JSON valide
            if (!$this->isValidJson($rawPayload)) {
                Log::error('Webhook Calendly - Le payload n\'est pas un JSON valide');
                // Enregistrer le payload complet pour analyse
                File::put(storage_path('logs/invalid_json_payload_' . date('Y-m-d_H-i-s') . '.txt'), $rawPayload);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payload JSON invalide'
                ], 400);
            }

            $payload = $request->all();
            Log::info('Webhook Calendly - Données décodées', [
                'event_type' => $payload['event'] ?? 'non spécifié',
                'full_payload' => $payload
            ]);

            // Traiter les données du webhook uniquement si c'est un événement de création de rendez-vous
            if (isset($payload['event']) && $payload['event'] === 'invitee.created') {
                $invitee = $payload['payload']['invitee'] ?? null;
                $event = $payload['payload']['event'] ?? null;

                Log::debug('Webhook Calendly - Données du rendez-vous', [
                    'invitee' => $invitee ? [
                        'email' => $invitee['email'] ?? 'non disponible',
                        'name' => $invitee['name'] ?? 'non disponible',
                        'uuid' => $invitee['uuid'] ?? 'non disponible',
                        'full_data' => $invitee
                    ] : null,
                    'event' => $event ? [
                        'name' => $event['name'] ?? 'non disponible',
                        'start_time' => $event['start_time'] ?? 'non disponible',
                        'full_data' => $event
                    ] : null
                ]);

                if (!$invitee || !$event) {
                    Log::error('Webhook Calendly - Données incomplètes', [
                        'has_invitee' => (bool)$invitee,
                        'has_event' => (bool)$event
                    ]);
                    return response()->json(['status' => 'error', 'message' => 'Données invalides'], 400);
                }

                if (empty($invitee['email'])) {
                    Log::error('Webhook Calendly - Email manquant dans les données invitee');
                    return response()->json(['status' => 'error', 'message' => 'Email manquant'], 400);
                }

                // Normaliser l'email (supprimer espaces, mettre en minuscules)
                $email = trim(strtolower($invitee['email']));
                Log::debug('Webhook Calendly - Recherche de lead par email', ['email' => $email]);

                // Trouver le lead associé à cet email
                $lead = Lead::where('email', $email)->first();

                if (!$lead) {
                    Log::warning('Webhook Calendly - Lead non trouvé pour cet email', [
                        'email' => $email
                    ]);

                    // Essayer avec une recherche moins stricte
                    $lead = Lead::where('email', 'like', '%' . $email . '%')->first();
                    if ($lead) {
                        Log::info('Webhook Calendly - Lead trouvé avec recherche partielle par email', [
                            'lead_id' => $lead->id,
                            'email_lead' => $lead->email,
                            'email_calendly' => $email
                        ]);
                    } else {
                        // Recherche par téléphone si disponible
                        if (!empty($invitee['text_reminder_number'])) {
                            $phoneNumber = $invitee['text_reminder_number'];
                            Log::debug('Webhook Calendly - Tentative de recherche par téléphone', [
                                'phone' => $phoneNumber
                            ]);

                            // Plusieurs formats de recherche de téléphone
                            $phoneClean = preg_replace('/[^0-9]/', '', $phoneNumber);
                            $phoneLastDigits = substr($phoneClean, -9);

                            Log::debug('Webhook Calendly - Formats de téléphone recherchés', [
                                'original' => $phoneNumber,
                                'clean' => $phoneClean,
                                'last_digits' => $phoneLastDigits
                            ]);

                            // Recherche avec différents formats
                            $lead = Lead::where('phone', 'like', '%' . $phoneLastDigits)->first();
                            if (!$lead) {
                                $lead = Lead::where('phone', 'like', '%' . $phoneClean)->first();
                            }

                            if ($lead) {
                                Log::info('Webhook Calendly - Lead trouvé par numéro de téléphone', [
                                    'lead_id' => $lead->id,
                                    'phone_lead' => $lead->phone,
                                    'phone_calendly' => $phoneNumber
                                ]);
                            }
                        }

                        // Recherche par nom si toujours pas trouvé
                        if (!$lead && !empty($invitee['name'])) {
                            $name = $invitee['name'];
                            $nameParts = explode(' ', $name);

                            if (count($nameParts) > 1) {
                                $firstName = trim($nameParts[0]);
                                $lastName = trim(implode(' ', array_slice($nameParts, 1)));

                                Log::debug('Webhook Calendly - Tentative de recherche par nom', [
                                    'first_name' => $firstName,
                                    'last_name' => $lastName
                                ]);

                                $lead = Lead::where('first_name', 'like', $firstName . '%')
                                           ->where('last_name', 'like', $lastName . '%')
                                           ->first();

                                if ($lead) {
                                    Log::info('Webhook Calendly - Lead trouvé par nom', [
                                        'lead_id' => $lead->id,
                                        'name_lead' => $lead->first_name . ' ' . $lead->last_name,
                                        'name_calendly' => $name
                                    ]);
                                }
                            }
                        }
                    }

                    if (!$lead) {
                        Log::error('Webhook Calendly - Lead introuvable malgré les différentes méthodes de recherche');
                        return response()->json(['status' => 'error', 'message' => 'Lead non trouvé'], 404);
                    }
                }

                Log::info('Webhook Calendly - Lead trouvé pour le rendez-vous', [
                    'lead_id' => $lead->id,
                    'email' => $lead->email,
                    'phone' => $lead->phone
                ]);

                // Mettre à jour les informations du rendez-vous
                $lead->appointment_date = $event['start_time'];
                $lead->appointment_id = $invitee['uuid'];
                $lead->status = 'appointment_scheduled';

                try {
                    $lead->save();
                    Log::info('Webhook Calendly - Rendez-vous enregistré dans le lead', [
                        'lead_id' => $lead->id,
                        'appointment_date' => $event['start_time'],
                        'appointment_id' => $invitee['uuid']
                    ]);
                } catch (\Exception $e) {
                    Log::error('Webhook Calendly - Erreur lors de l\'enregistrement du rendez-vous', [
                        'lead_id' => $lead->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw $e;
                }

                // Envoyer un email de confirmation directement avec une méthode simplifiée
                try {
                    // Capturer le statut du lead avant modification
                    $previousStatus = $lead->getOriginal('status');

                    // Récupérer l'email actuel pour comparaison
                    $leadEmail = $lead->email;

                    // Vérification préalable du lead et des services
                    Log::info('Webhook Calendly - Préparation envoi email', [
                        'lead_id' => $lead->id,
                        'email' => $leadEmail,
                        'status' => $lead->status,
                        'previous_status' => $previousStatus,
                        'appointment_date' => $event['start_time']
                    ]);

                    // Vérification de la configuration email
                    $mailConfig = [
                        'driver' => config('mail.default'),
                        'host' => config('mail.mailers.smtp.host'),
                        'port' => config('mail.mailers.smtp.port'),
                        'from' => config('mail.from.address'),
                    ];

                    Log::debug('Webhook Calendly - Configuration mail actuelle', $mailConfig);

                    // Forcer un rafraîchissement du modèle Lead avant d'envoyer l'email
                    $lead->refresh();

                    // Appel direct du service d'email
                    $emailSent = $this->emailService->sendAppointmentConfirmation($lead, $event['start_time']);

                    // Log détaillé de l'email
                    Log::info('Webhook Calendly - Email de confirmation envoyé', [
                        'lead_id' => $lead->id,
                        'email_sent' => $emailSent ? 'succès' : 'échec',
                        'email_to' => $lead->email,
                        'appointment_date' => $event['start_time']
                    ]);

                    // Si l'envoi a échoué mais qu'on est en mode debug, essayer avec mail() natif
                    if (!$emailSent && env('APP_DEBUG', false)) {
                        Log::warning('Webhook Calendly - Tentative d\'envoi avec mail() natif', [
                            'email' => $lead->email
                        ]);

                        $subject = 'Confirmation de rendez-vous - Lead Factory';
                        $message = "Votre rendez-vous a été confirmé pour le " . date('d/m/Y à H:i', strtotime($event['start_time']));
                        $headers = 'From: ' . config('mail.from.address') . "\r\n" .
                                   'Reply-To: ' . config('mail.from.address') . "\r\n" .
                                   'X-Mailer: PHP/' . phpversion();

                        $fallbackSent = mail($lead->email, $subject, $message, $headers);

                        Log::info('Webhook Calendly - Résultat mail() natif', [
                            'email' => $lead->email,
                            'success' => $fallbackSent
                        ]);

                        // Mise à jour du statut d'envoi si mail() a réussi
                        $emailSent = $emailSent || $fallbackSent;
                    }
                } catch (\Exception $e) {
                    $emailSent = false;
                    Log::error('Webhook Calendly - Exception lors de l\'envoi d\'email', [
                        'lead_id' => $lead->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);

                    // Enregistrer l'erreur détaillée dans un fichier pour analyse
                    $errorLogPath = storage_path('logs/email_error_' . date('Y-m-d_H-i-s') . '.txt');
                    File::put($errorLogPath, "Erreur d'envoi d'email:\n" .
                                            "Lead ID: " . $lead->id . "\n" .
                                            "Email: " . $lead->email . "\n" .
                                            "Date: " . date('Y-m-d H:i:s') . "\n" .
                                            "Erreur: " . $e->getMessage() . "\n\n" .
                                            "Trace:\n" . $e->getTraceAsString());

                    Log::error('Webhook Calendly - Détails de l\'erreur enregistrés dans ' . $errorLogPath);
                }

                // Envoyer un SMS de confirmation
                try {
                    $smsSent = $this->twilioService->sendAppointmentConfirmation($lead, $event['start_time']);
                    Log::info('Webhook Calendly - SMS de confirmation envoyé', [
                        'lead_id' => $lead->id,
                        'sms_sent' => $smsSent ? 'succès' : 'échec',
                        'phone_to' => $lead->phone
                    ]);
                } catch (\Exception $e) {
                    $smsSent = false;
                    Log::error('Webhook Calendly - Exception lors de l\'envoi de SMS', [
                        'lead_id' => $lead->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }

                Log::info('✅ FIN TRAITEMENT WEBHOOK CALENDLY - Succès');
                return response()->json([
                    'status' => 'success',
                    'message' => 'Rendez-vous traité avec succès',
                    'lead_id' => $lead->id,
                    'email_sent' => $emailSent,
                    'sms_sent' => $smsSent
                ]);
            } else {
                // Évènement différent, le logger quand même
                Log::info('Webhook Calendly - Événement différent de invitee.created', [
                    'event' => $payload['event'] ?? 'non défini'
                ]);
            }

            Log::info('⏩ FIN TRAITEMENT WEBHOOK CALENDLY - Ignoré (type d\'événement non traité)');
            return response()->json(['status' => 'ignored', 'message' => 'Événement ignoré']);
        } catch (\Exception $e) {
            Log::error('❌ ERREUR WEBHOOK CALENDLY', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Vérifie si une chaîne est du JSON valide
     *
     * @param string $string
     * @return bool
     */
    protected function isValidJson($string) {
        if (!is_string($string) || empty($string)) {
            return false;
        }

        json_decode($string);
        return (json_last_error() === JSON_ERROR_NONE);
    }

    /**
     * Affiche la page de confirmation après la prise de rendez-vous.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function confirmation(Request $request)
    {
        $leadId = $request->input('lead_id');
        $lead = Lead::findOrFail($leadId);

        return view('confirmation', [
            'lead' => $lead
        ]);
    }
}
