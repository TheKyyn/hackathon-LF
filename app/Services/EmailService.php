<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReminderMail;
use App\Mail\AppointmentConfirmationMail;

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
            // Utiliser la date fournie ou celle du lead
            $date = $appointmentDate ? $appointmentDate : $lead->appointment_date;

            if (!$date) {
                Log::warning('Aucune date de rendez-vous disponible pour l\'envoi d\'email de confirmation', [
                    'lead_id' => $lead->id
                ]);
                return false;
            }

            // Envoyer l'email
            Mail::to($lead->email)->send(new AppointmentConfirmationMail($lead, $date));

            Log::info('Email de confirmation envoyé', [
                'lead_id' => $lead->id,
                'email' => $lead->email
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Erreur d\'envoi email de confirmation: ' . $e->getMessage(), [
                'lead_id' => $lead->id,
                'email' => $lead->email,
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
            if (!$lead->appointment_date) {
                Log::warning('Aucune date de rendez-vous disponible pour l\'envoi d\'email de rappel', [
                    'lead_id' => $lead->id
                ]);
                return false;
            }

            // Envoyer l'email
            Mail::to($lead->email)->send(new AppointmentReminderMail($lead, $hoursBeforeAppointment));

            Log::info('Email de rappel envoyé', [
                'lead_id' => $lead->id,
                'email' => $lead->email,
                'hours_before' => $hoursBeforeAppointment
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Erreur d\'envoi email de rappel: ' . $e->getMessage(), [
                'lead_id' => $lead->id,
                'email' => $lead->email,
                'trace' => $e->getTraceAsString()
            ]);

            return false;
        }
    }
}
