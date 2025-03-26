<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $hoursBeforeAppointment;
    public $formattedDate;

    /**
     * Crée une nouvelle instance de l'email.
     *
     * @param Lead $lead
     * @param int $hoursBeforeAppointment
     * @return void
     */
    public function __construct(Lead $lead, int $hoursBeforeAppointment = 24)
    {
        $this->lead = $lead;
        $this->hoursBeforeAppointment = $hoursBeforeAppointment;

        // Formater la date pour l'affichage
        if ($lead->appointment_date) {
            $date = new \DateTime($lead->appointment_date);
            $this->formattedDate = $date->format('d/m/Y à H:i');
        } else {
            $this->formattedDate = 'Non spécifiée';
        }
    }

    /**
     * Construit l'email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Rappel de votre rendez-vous - Panneaux solaires')
                    ->markdown('emails.appointment-reminder')
                    ->with([
                        'lead' => $this->lead,
                        'formattedDate' => $this->formattedDate,
                        'hoursBeforeAppointment' => $this->hoursBeforeAppointment
                    ]);
    }
}
