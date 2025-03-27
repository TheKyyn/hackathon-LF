<?php

namespace App\Console\Commands;

use App\Models\Lead;
use App\Services\CalendlyService;
use App\Services\EmailService;
use App\Services\TwilioService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendly:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie des rappels pour les rendez-vous à venir dans 24h';

    /**
     * Services d'envoi de SMS et d'emails
     */
    protected $calendlyService;
    protected $emailService;
    protected $twilioService;

    /**
     * Create a new command instance.
     */
    public function __construct(CalendlyService $calendlyService, EmailService $emailService, TwilioService $twilioService)
    {
        parent::__construct();
        $this->calendlyService = $calendlyService;
        $this->emailService = $emailService;
        $this->twilioService = $twilioService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Vérification des rendez-vous à venir pour envoyer des rappels...');

        // Récupérer les rendez-vous à venir dans les prochaines 24h
        $appointments = $this->calendlyService->getUpcomingAppointments();

        if (empty($appointments)) {
            $this->info('Aucun rendez-vous à venir dans les prochaines 24h.');
            return;
        }

        $this->info(count($appointments) . ' rendez-vous à venir trouvés.');

        $processedCount = 0;
        $errorCount = 0;

        foreach ($appointments as $appointment) {
            $event = $appointment['event'];
            $invitee = $appointment['invitee'];

            $email = $invitee['email'] ?? null;

            if (!$email) {
                $this->warn('Email manquant pour un invité.');
                continue;
            }

            // Trouver le lead correspondant à cet email
            $lead = Lead::where('email', $email)->first();

            if (!$lead) {
                $this->warn("Aucun lead trouvé pour l'email: $email");
                continue;
            }

            // Vérifier si le rendez-vous est bien enregistré
            if (!$lead->appointment_date || !$lead->appointment_id) {
                $this->warn("Rendez-vous non enregistré pour le lead: {$lead->email}");

                // Mettre à jour les informations du rendez-vous
                $lead->appointment_date = $event['start_time_pretty'] ?? $event['start_time'];
                $lead->appointment_id = $invitee['uri'];
                $lead->status = 'appointment_scheduled';
                $lead->save();
            }

            try {
                // Vérifier si un rappel a déjà été envoyé
                if ($lead->reminder_sent) {
                    $this->info("Rappel déjà envoyé pour le lead: {$lead->email}");
                    continue;
                }

                // Envoyer un email de rappel
                $emailSent = $this->emailService->sendAppointmentReminder($lead);

                // Envoyer un SMS de rappel
                $smsSent = $this->twilioService->sendAppointmentReminder($lead);

                if ($emailSent || $smsSent) {
                    // Marquer le rappel comme envoyé
                    $lead->reminder_sent = true;
                    $lead->save();

                    $this->info("Rappel envoyé pour le lead: {$lead->email}");
                    $processedCount++;
                } else {
                    $this->error("Erreur lors de l'envoi du rappel pour le lead: {$lead->email}");
                    $errorCount++;
                }
            } catch (\Exception $e) {
                $this->error("Exception lors de l'envoi du rappel: " . $e->getMessage());
                Log::error("Exception lors de l'envoi du rappel pour rendez-vous: " . $e->getMessage(), [
                    'lead_id' => $lead->id,
                    'email' => $email,
                    'trace' => $e->getTraceAsString()
                ]);
                $errorCount++;
            }
        }

        $this->info("Traitement terminé: $processedCount rappels envoyés, $errorCount erreurs.");
    }
}
