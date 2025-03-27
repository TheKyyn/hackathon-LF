<?php

namespace App\Console\Commands;

use App\Models\Lead;
use App\Services\EmailService;
use Illuminate\Console\Command;

class TestAppointmentEmails extends Command
{
    protected $signature = 'email:test-appointment {email?}';
    protected $description = 'Envoie un email de test de confirmation de rendez-vous';

    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        parent::__construct();
        $this->emailService = $emailService;
    }

    public function handle()
    {
        $email = $this->argument('email') ?? 'test@example.com';

        // Créer un lead de test ou utiliser un existant
        $lead = Lead::where('email', $email)->first();

        if (!$lead) {
            $lead = new Lead();
            $lead->first_name = 'Test';
            $lead->last_name = 'User';
            $lead->email = $email;
            $lead->phone = '+33627662449';
            $lead->save();

            $this->info("Lead de test créé avec l'email: {$email}");
        }

        // Définir une date de rendez-vous test (demain à 14h)
        $tomorrow = now()->addDay()->setHour(14)->setMinute(0);
        $appointmentDate = $tomorrow->format('Y-m-d\TH:i:s\Z');

        $this->info('Envoi de l\'email de confirmation en cours...');

        if ($this->emailService->sendAppointmentConfirmation($lead, $appointmentDate)) {
            $this->info('Email de confirmation envoyé avec succès!');
            $this->info('Vérifiez votre boîte de réception Mailtrap pour voir l\'email.');
        } else {
            $this->error('Erreur lors de l\'envoi de l\'email de confirmation.');
        }

        $this->info('Envoi de l\'email de rappel en cours...');

        if ($this->emailService->sendAppointmentReminder($lead)) {
            $this->info('Email de rappel envoyé avec succès!');
            $this->info('Vérifiez votre boîte de réception Mailtrap pour voir l\'email.');
        } else {
            $this->error('Erreur lors de l\'envoi de l\'email de rappel.');
        }
    }
}
