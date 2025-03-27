<?php

namespace App\Services;

use App\Models\Lead;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected $client;
    protected $fromNumber;

    /**
     * Initialise le service Twilio avec les informations d'authentification
     */
    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        $this->fromNumber = config('services.twilio.from');
    }

    /**
     * Envoie un SMS via Twilio
     *
     * @param string $to Numéro de téléphone du destinataire
     * @param string $message Contenu du message
     * @return bool
     */
    public function sendSMS(string $to, string $message): bool
    {
        try {
            $message = $this->client->messages->create(
                $to,
                [
                    'from' => $this->fromNumber,
                    'body' => $message
                ]
            );

            Log::info('SMS envoyé avec succès', [
                'to' => $to,
                'message_sid' => $message->sid
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi du SMS', [
                'error' => $e->getMessage(),
                'to' => $to
            ]);

            return false;
        }
    }

    /**
     * Envoie un SMS de confirmation de rendez-vous
     *
     * @param Lead $lead Le lead auquel envoyer le SMS
     * @param string $appointmentDate Date et heure du rendez-vous
     * @return bool Succès ou échec de l'envoi
     */
    public function sendAppointmentConfirmation(Lead $lead, string $appointmentDate = null)
    {
        if (!$this->client || !$this->fromNumber) {
            Log::warning('Service Twilio non configuré correctement');
            return false;
        }

        try {
            // Formater la date de rendez-vous si fournie
            $formattedDate = '';
            if ($appointmentDate) {
                $date = new \DateTime($appointmentDate);
                $formattedDate = $date->format('d/m/Y à H:i');
            } else if ($lead->appointment_date) {
                $date = new \DateTime($lead->appointment_date);
                $formattedDate = $date->format('d/m/Y à H:i');
            }

            // Préparer le message
            $message = "Bonjour {$lead->first_name}, votre rendez-vous pour discuter de vos panneaux solaires est confirmé";

            if ($formattedDate) {
                $message .= " pour le {$formattedDate}";
            }

            $message .= ". À bientôt! La Factory";

            // Envoyer le SMS
            $this->client->messages->create(
                $lead->phone, // Destinataire
                [
                    'from' => $this->fromNumber,
                    'body' => $message
                ]
            );

            Log::info('SMS de confirmation envoyé', ['lead_id' => $lead->id, 'phone' => $lead->phone]);
            return true;
        } catch (\Exception $e) {
            Log::error('Erreur d\'envoi SMS: ' . $e->getMessage(), [
                'lead_id' => $lead->id,
                'phone' => $lead->phone,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Envoie un SMS de rappel de rendez-vous
     *
     * @param Lead $lead Le lead auquel envoyer le SMS
     * @param int $hoursBeforeAppointment Heures avant le rendez-vous pour envoyer le rappel
     * @return bool Succès ou échec de l'envoi
     */
    public function sendAppointmentReminder(Lead $lead, int $hoursBeforeAppointment = 24)
    {
        if (!$this->client || !$this->fromNumber || !$lead->appointment_date) {
            Log::warning('Service Twilio non configuré ou pas de date de rendez-vous');
            return false;
        }

        try {
            // Formater la date de rendez-vous
            $date = new \DateTime($lead->appointment_date);
            $formattedDate = $date->format('d/m/Y à H:i');

            // Préparer le message
            $message = "Rappel: Vous avez rendez-vous le {$formattedDate} avec un expert La Factory pour discuter de votre projet de panneaux solaires. À bientôt!";

            // Envoyer le SMS
            $this->client->messages->create(
                $lead->phone, // Destinataire
                [
                    'from' => $this->fromNumber,
                    'body' => $message
                ]
            );

            Log::info('SMS de rappel envoyé', ['lead_id' => $lead->id, 'phone' => $lead->phone]);
            return true;
        } catch (\Exception $e) {
            Log::error('Erreur d\'envoi SMS rappel: ' . $e->getMessage(), [
                'lead_id' => $lead->id,
                'phone' => $lead->phone
            ]);
            return false;
        }
    }
}
