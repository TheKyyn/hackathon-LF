<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $appointmentDate;
    public $formattedDate;

    /**
     * Crée une nouvelle instance de l'email.
     *
     * @param Lead $lead
     * @param string $appointmentDate
     * @return void
     */
    public function __construct(Lead $lead, string $appointmentDate)
    {
        $this->lead = $lead;
        $this->appointmentDate = $appointmentDate;

        // Formater la date pour l'affichage
        $date = new \DateTime($appointmentDate);
        $this->formattedDate = $date->format('d/m/Y à H:i');
    }

    /**
     * Construit l'email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirmation de votre rendez-vous - Panneaux solaires')
                    ->markdown('emails.appointment-confirmation')
                    ->with([
                        'lead' => $this->lead,
                        'formattedDate' => $this->formattedDate
                    ]);
    }
}