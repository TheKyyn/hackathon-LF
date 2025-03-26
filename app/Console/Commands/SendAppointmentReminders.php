<?php

namespace App\Console\Commands;

use App\Models\Lead;
use App\Services\TwilioService;
use App\Services\EmailService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-appointment-reminders {hours=24 : Heures avant le rendez-vous pour envoyer le rappel}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie des rappels de rendez-vous par email et SMS aux leads';

    /**
     * Services d'envoi de SMS et d'emails
     */
    protected $twilioService;
    protected $emailService;

    /**
     * Create a new command instance.
     */
    public function __construct(TwilioService $twilioService, EmailService $emailService)
    {
        parent::__construct();
        $this->twilioService = $twilioService;
        $this->emailService = $emailService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoursBeforeAppointment = $this->argument('hours');
        $this->info("Recherche des rendez-vous prévus dans {$hoursBeforeAppointment} heures...");

        try {
            // Calculer la date cible (rendez-vous dans X heures)
            $targetDate = Carbon::now()->addHours($hoursBeforeAppointment);

            // Fenêtre de temps d'une heure pour trouver les rendez-vous
            $startTime = $targetDate->copy()->subMinutes(30);
            $endTime = $targetDate->copy()->addMinutes(30);

            // Rechercher les leads avec un rendez-vous dans cette fenêtre
            $leads = Lead::whereNotNull('appointment_date')
                ->where('appointment_date', '>=', $startTime->toDateTimeString())
                ->where('appointment_date', '<=', $endTime->toDateTimeString())
                ->get();

            $count = $leads->count();
            $this->info("Trouvé {$count} leads avec un rendez-vous à venir dans ~{$hoursBeforeAppointment} heures.");

            if ($count === 0) {
                return 0;
            }

            $bar = $this->output->createProgressBar($count);
            $bar->start();

            $success = 0;
            $errors = 0;

            foreach ($leads as $lead) {
                $this->line("\nTraitement du lead #{$lead->id} - {$lead->email}");

                // Envoyer le rappel par email
                $emailSent = $this->emailService->sendAppointmentReminder($lead, $hoursBeforeAppointment);

                // Envoyer le rappel par SMS
                $smsSent = $this->twilioService->sendAppointmentReminder($lead, $hoursBeforeAppointment);

                if ($emailSent && $smsSent) {
                    $success++;
                    $this->info("  ✓ Rappels envoyés avec succès");
                } else {
                    $errors++;
                    $this->error("  ✗ Erreur lors de l'envoi des rappels");
                }

                $bar->advance();
            }

            $bar->finish();

            $this->newLine(2);
            $this->info("Traitement terminé : {$success} rappels envoyés, {$errors} erreurs.");

            return 0;
        } catch (\Exception $e) {
            $this->error("Une erreur est survenue : " . $e->getMessage());
            Log::error('Erreur lors de l\'envoi des rappels de rendez-vous: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return 1;
        }
    }
}
