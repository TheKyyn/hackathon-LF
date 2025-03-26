<?php

namespace App\Console\Commands;

use App\Models\Lead;
use App\Services\TwilioService;
use App\Services\EmailService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendAppointmentConfirmations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-appointment-confirmations {--hours=24 : Rendez-vous créés dans les dernières X heures}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie des confirmations de rendez-vous par email et SMS aux leads ayant récemment pris rendez-vous';

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
        $hours = $this->option('hours');
        $this->info("Recherche des rendez-vous créés dans les {$hours} dernières heures...");

        try {
            // Calculer la période de recherche
            $startTime = Carbon::now()->subHours($hours);

            // Rechercher les leads avec un rendez-vous créé dans cette période
            $leads = Lead::whereNotNull('appointment_date')
                ->where('status', 'appointment_scheduled')
                ->where('updated_at', '>=', $startTime->toDateTimeString())
                ->get();

            $count = $leads->count();
            $this->info("Trouvé {$count} leads avec un rendez-vous récemment créé.");

            if ($count === 0) {
                return 0;
            }

            $bar = $this->output->createProgressBar($count);
            $bar->start();

            $success = 0;
            $errors = 0;

            foreach ($leads as $lead) {
                $this->line("\nTraitement du lead #{$lead->id} - {$lead->email}");

                // Envoyer la confirmation par email
                $emailSent = $this->emailService->sendAppointmentConfirmation($lead);

                // Envoyer la confirmation par SMS
                $smsSent = $this->twilioService->sendAppointmentConfirmation($lead);

                if ($emailSent && $smsSent) {
                    $success++;
                    $this->info("  ✓ Confirmations envoyées avec succès");

                    // Mettre à jour le statut du lead
                    $lead->status = 'confirmation_sent';
                    $lead->save();
                } else {
                    $errors++;
                    $this->error("  ✗ Erreur lors de l'envoi des confirmations");
                }

                $bar->advance();
            }

            $bar->finish();

            $this->newLine(2);
            $this->info("Traitement terminé : {$success} confirmations envoyées, {$errors} erreurs.");

            return 0;
        } catch (\Exception $e) {
            $this->error("Une erreur est survenue : " . $e->getMessage());
            Log::error('Erreur lors de l\'envoi des confirmations: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return 1;
        }
    }
}
