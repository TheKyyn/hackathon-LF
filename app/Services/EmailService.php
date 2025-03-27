<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReminderMail;
use App\Mail\AppointmentConfirmationMail;
use Illuminate\Support\Facades\File;

class EmailService
{
    /**
     * Envoie un email de confirmation après la prise de rendez-vous
     *
     * @param Lead $lead Le lead auquel envoyer l'email
     * @param string $appointmentDate Date et heure du rendez-vous
     * @return bool Succès ou échec de l'envoi
     */
    public function sendAppointmentConfirmation(Lead $lead, string $appointmentDate = null)
    {
        try {
            $logContext = [
                'lead_id' => $lead->id,
                'email' => $lead->email,
                'appointment_date' => $appointmentDate ?? $lead->appointment_date
            ];

            Log::info('📧 DÉBUT ENVOI EMAIL CONFIRMATION', $logContext);

            // Vérifier que l'email est bien formaté
            if (!filter_var($lead->email, FILTER_VALIDATE_EMAIL)) {
                Log::error('Email invalide pour l\'envoi', [
                    'lead_id' => $lead->id,
                    'email' => $lead->email
                ]);
                return false;
            }

            // Utiliser la date fournie ou celle du lead
            $date = $appointmentDate ? $appointmentDate : $lead->appointment_date;

            if (!$date) {
                Log::warning('Aucune date de rendez-vous disponible pour l\'envoi d\'email de confirmation', [
                    'lead_id' => $lead->id
                ]);
                return false;
            }

            // S'assurer que les adresses d'expéditeur sont correctes
            $fromAddress = config('mail.from.address');
            $fromName = config('mail.from.name');

            if (empty($fromAddress) || $fromAddress === 'hello@example.com') {
                $fromAddress = 'noreply@lead-factory.fr';
                Log::warning('Adresse d\'expéditeur non configurée, utilisation de la valeur par défaut', [
                    'from_address' => $fromAddress
                ]);
            }

            if (empty($fromName) || $fromName === 'Laravel') {
                $fromName = 'Lead Factory';
                Log::warning('Nom d\'expéditeur non configuré, utilisation de la valeur par défaut', [
                    'from_name' => $fromName
                ]);
            }

            // Capturer le contenu de l'email pour debug
            $mailInstance = new AppointmentConfirmationMail($lead, $date);
            $mailContent = $mailInstance->render();

            // Enregistrer le rendu de l'email pour debug
            $debugPath = storage_path('logs/email_' . $lead->id . '_' . date('YmdHis') . '.html');
            File::put($debugPath, $mailContent);

            Log::debug('Email généré et prêt pour envoi', [
                'lead_id' => $lead->id,
                'email' => $lead->email,
                'debug_file' => $debugPath,
                'subject' => $mailInstance->subject ?? 'Confirmation de rendez-vous'
            ]);

            // Envoyer l'email avec gestion d'erreurs plus détaillée
            try {
                // Vérifier la configuration d'email
                $mailConfig = config('mail');
                Log::debug('Configuration email actuelle', [
                    'driver' => $mailConfig['default'] ?? 'non défini',
                    'from_address' => $mailConfig['from']['address'] ?? 'non défini',
                    'from_name' => $mailConfig['from']['name'] ?? 'non défini',
                    'host' => $mailConfig['mailers']['smtp']['host'] ?? 'non défini',
                    'port' => $mailConfig['mailers']['smtp']['port'] ?? 'non défini'
                ]);

                // Forcer l'adresse d'expédition pour ce mail
                $mailInstance->from($fromAddress, $fromName);

                // Tentative d'envoi de l'email
                Mail::to($lead->email)->send($mailInstance);

                // Vérifier si l'envoi a généré des erreurs
                $failures = Mail::failures();
                if (!empty($failures)) {
                    Log::error('Échecs détectés lors de l\'envoi d\'email', [
                        'failures' => $failures,
                        'lead_id' => $lead->id,
                        'email' => $lead->email
                    ]);

                    // Fallback avec mail() natif si Laravel Mail échoue
                    Log::info('Tentative d\'envoi avec mail() natif après échec Laravel Mail');
                    $subject = 'Confirmation de votre rendez-vous - Panneaux solaires';
                    $message = "Bonjour {$lead->first_name},\n\n";
                    $message .= "Votre rendez-vous est confirmé pour le " . date('d/m/Y à H:i', strtotime($date)) . ".\n\n";
                    $message .= "À bientôt!\nLead Factory";

                    $headers = 'From: ' . $fromAddress . "\r\n" .
                              'Reply-To: ' . $fromAddress . "\r\n" .
                              'X-Mailer: PHP/' . phpversion();

                    $mailResult = mail($lead->email, $subject, $message, $headers);

                    if ($mailResult) {
                        Log::info('✅ EMAIL DE SECOURS ENVOYÉ AVEC SUCCÈS (mail() natif)', [
                            'lead_id' => $lead->id,
                            'email' => $lead->email
                        ]);
                        return true;
                    }

                    return false;
                }

                Log::info('✅ EMAIL DE CONFIRMATION ENVOYÉ AVEC SUCCÈS', [
                    'lead_id' => $lead->id,
                    'email' => $lead->email,
                    'date' => date('Y-m-d H:i:s')
                ]);

                return true;
            } catch (\Exception $e) {
                Log::error('Erreur de transport lors de l\'envoi d\'email', [
                    'lead_id' => $lead->id,
                    'email' => $lead->email,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                // Fallback avec mail() natif en cas d'exception
                Log::info('Tentative d\'envoi avec mail() natif après exception');
                $subject = 'Confirmation de votre rendez-vous - Panneaux solaires';
                $message = "Bonjour {$lead->first_name},\n\n";
                $message .= "Votre rendez-vous est confirmé pour le " . date('d/m/Y à H:i', strtotime($date)) . ".\n\n";
                $message .= "À bientôt!\nLead Factory";

                $headers = 'From: ' . $fromAddress . "\r\n" .
                          'Reply-To: ' . $fromAddress . "\r\n" .
                          'X-Mailer: PHP/' . phpversion();

                $mailResult = mail($lead->email, $subject, $message, $headers);

                if ($mailResult) {
                    Log::info('✅ EMAIL DE SECOURS ENVOYÉ AVEC SUCCÈS (mail() natif)', [
                        'lead_id' => $lead->id,
                        'email' => $lead->email
                    ]);
                    return true;
                }

                return false;
            }
        } catch (\Exception $e) {
            Log::error('❌ ERREUR D\'ENVOI EMAIL DE CONFIRMATION', [
                'lead_id' => $lead->id ?? 'inconnu',
                'email' => $lead->email ?? 'inconnu',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return false;
        }
    }

    /**
     * Envoie un email de rappel avant le rendez-vous
     *
     * @param Lead $lead Le lead auquel envoyer l'email
     * @param int $hoursBeforeAppointment Heures avant le rendez-vous pour envoyer le rappel
     * @return bool Succès ou échec de l'envoi
     */
    public function sendAppointmentReminder(Lead $lead, int $hoursBeforeAppointment = 24)
    {
        try {
            $logContext = [
                'lead_id' => $lead->id,
                'email' => $lead->email,
                'hours_before' => $hoursBeforeAppointment
            ];

            Log::info('📧 DÉBUT ENVOI EMAIL RAPPEL', $logContext);

            if (!filter_var($lead->email, FILTER_VALIDATE_EMAIL)) {
                Log::error('Email invalide pour l\'envoi de rappel', [
                    'lead_id' => $lead->id,
                    'email' => $lead->email
                ]);
                return false;
            }

            if (!$lead->appointment_date) {
                Log::warning('Aucune date de rendez-vous disponible pour l\'envoi d\'email de rappel', [
                    'lead_id' => $lead->id
                ]);
                return false;
            }

            // Capturer le contenu de l'email pour debug
            $mailInstance = new AppointmentReminderMail($lead, $hoursBeforeAppointment);
            $mailContent = $mailInstance->render();

            // Enregistrer le rendu de l'email pour debug
            $debugPath = storage_path('logs/email_reminder_' . $lead->id . '_' . date('YmdHis') . '.html');
            File::put($debugPath, $mailContent);

            Log::debug('Email de rappel généré et prêt pour envoi', [
                'lead_id' => $lead->id,
                'email' => $lead->email,
                'debug_file' => $debugPath,
                'subject' => $mailInstance->subject ?? 'Rappel de rendez-vous'
            ]);

            // Envoyer l'email
            try {
                Mail::to($lead->email)->send($mailInstance);

                // Vérifier si l'envoi a généré des erreurs
                $failures = Mail::failures();
                if (!empty($failures)) {
                    Log::error('Échecs détectés lors de l\'envoi d\'email de rappel', [
                        'failures' => $failures,
                        'lead_id' => $lead->id,
                        'email' => $lead->email
                    ]);
                    return false;
                }

                Log::info('✅ EMAIL DE RAPPEL ENVOYÉ AVEC SUCCÈS', [
                    'lead_id' => $lead->id,
                    'email' => $lead->email,
                    'date' => date('Y-m-d H:i:s')
                ]);

                return true;
            } catch (\Exception $e) {
                Log::error('Erreur de transport lors de l\'envoi d\'email de rappel', [
                    'lead_id' => $lead->id,
                    'email' => $lead->email,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('❌ ERREUR D\'ENVOI EMAIL DE RAPPEL', [
                'lead_id' => $lead->id ?? 'inconnu',
                'email' => $lead->email ?? 'inconnu',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return false;
        }
    }

    /**
     * Envoie un email de test pour vérifier que le système d'email fonctionne
     *
     * @param string $email Adresse email de destination
     * @return bool Succès ou échec de l'envoi
     */
    public function sendTestEmail(string $email)
    {
        try {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Log::error('Email de test invalide', ['email' => $email]);
                return false;
            }

            Log::info('📧 ENVOI EMAIL DE TEST', ['email' => $email]);

            $content = '<h1>Test d\'envoi d\'email</h1>
                        <p>Ceci est un test envoyé le ' . date('d/m/Y à H:i:s') . '</p>
                        <p>Si vous recevez cet email, votre système d\'envoi d\'emails fonctionne correctement.</p>';

            Mail::html($content, function ($message) use ($email) {
                $message->to($email)
                        ->subject('Test d\'envoi d\'email - Lead Factory');
            });

            $failures = Mail::failures();
            if (!empty($failures)) {
                Log::error('Échecs détectés lors de l\'envoi d\'email de test', ['failures' => $failures]);
                return false;
            }

            Log::info('✅ EMAIL DE TEST ENVOYÉ AVEC SUCCÈS', ['email' => $email]);
            return true;

        } catch (\Exception $e) {
            Log::error('❌ ERREUR D\'ENVOI EMAIL DE TEST', [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
}
