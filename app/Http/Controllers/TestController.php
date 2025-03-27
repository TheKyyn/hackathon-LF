<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\EmailService;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    protected $twilioService;
    protected $emailService;

    /**
     * Constructeur avec injection de dépendances
     */
    public function __construct(TwilioService $twilioService, EmailService $emailService)
    {
        $this->twilioService = $twilioService;
        $this->emailService = $emailService;
    }

    /**
     * Affiche la configuration SMTP actuelle
     *
     * @return \Illuminate\Http\Response
     */
    public function showEmailConfig()
    {
        // Récupérer la configuration SMTP
        $config = $this->getEmailConfig();

        // Vérifier la connectivité SMTP
        $smtpStatus = $this->checkSmtpConnectivity();

        return response()->json([
            'config' => $config,
            'smtp_connectivity' => $smtpStatus
        ]);
    }

    /**
     * Test de l'envoi d'email directement en utilisant la fonction mail() native de PHP
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function testNativeMail(Request $request)
    {
        $email = $request->input('email');

        if (!$email) {
            return response()->json(['error' => 'Email requis'], 400);
        }

        $subject = 'Test PHP mail() depuis Lead Factory';
        $message = "Ceci est un email de test envoyé via la fonction native PHP mail().\n\n";
        $message .= "Date et heure: " . date('Y-m-d H:i:s') . "\n";
        $message .= "Cette méthode contourne la configuration Laravel et utilise directement la configuration PHP du serveur.";

        $headers = 'From: ' . env('MAIL_FROM_ADDRESS', 'noreply@lead-factory.fr') . "\r\n" .
            'Reply-To: ' . env('MAIL_FROM_ADDRESS', 'noreply@lead-factory.fr') . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        try {
            $result = mail($email, $subject, $message, $headers);

            Log::info('Test d\'envoi d\'email via mail() PHP', [
                'email' => $email,
                'success' => $result
            ]);

            return response()->json([
                'success' => $result,
                'message' => $result ? 'Email envoyé avec succès via mail() PHP' : 'Échec de l\'envoi via mail() PHP',
                'email' => $email
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors du test d\'envoi d\'email via mail() PHP', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'email' => $email
            ], 500);
        }
    }

    /**
     * Test de l'envoi d'email directement
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function testEmailSending(Request $request)
    {
        $email = $request->input('email');

        if (!$email) {
            return view('test-email');
        }

        try {
            // Vérifier si nous avons un lead existant
            $lead = Lead::where('email', $email)->first();

            // Si nous avons un lead, utiliser le service d'email
            if ($lead) {
                $emailService = new EmailService();
                $result = $emailService->sendAppointmentConfirmation($lead);

                Log::info('Test d\'envoi d\'email avec le lead existant', [
                    'email' => $email,
                    'lead_id' => $lead->id,
                    'success' => true
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Email de confirmation envoyé avec succès au lead existant',
                    'lead' => $lead,
                    'email_config' => $this->getEmailConfig(),
                    'result' => $result
                ]);
            }

            // Si nous n'avons pas de lead, envoyer un email de test simple
            Mail::raw('Ceci est un email de test envoyé à ' . $email, function ($message) use ($email) {
                $message->to($email)
                    ->subject('Test d\'envoi d\'email depuis Lead Factory');
            });

            Log::info('Test d\'envoi d\'email simple', [
                'email' => $email,
                'success' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email de test simple envoyé avec succès',
                'email' => $email,
                'email_config' => $this->getEmailConfig()
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors du test d\'envoi d\'email', [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'email_config' => $this->getEmailConfig()
            ], 500);
        }
    }

    /**
     * Teste le webhook Calendly
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function testCalendlyWebhook(Request $request)
    {
        $email = $request->input('email');
        if (!$email) {
            return response()->json(['error' => 'Email requis'], 400);
        }

        // Rechercher un lead existant
        $lead = Lead::where('email', $email)->first();

        if (!$lead) {
            return response()->json(['error' => 'Lead non trouvé avec cet email'], 404);
        }

        // Simuler l'envoi d'email
        try {
            $emailService = new EmailService();
            $result = $emailService->sendAppointmentConfirmation($lead);
            return response()->json([
                'success' => true,
                'message' => 'Email de confirmation envoyé avec succès',
                'lead' => $lead,
                'result' => $result
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors du test de webhook Calendly', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function getEmailConfig()
    {
        return [
            'driver' => config('mail.default'),
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'encryption' => config('mail.mailers.smtp.encryption'),
            'username' => config('mail.mailers.smtp.username') ? '(défini)' : '(non défini)',
            'password' => config('mail.mailers.smtp.password') ? '(défini)' : '(non défini)',
            'from_address' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
        ];
    }

    private function checkSmtpConnectivity()
    {
        $host = config('mail.mailers.smtp.host');
        $port = config('mail.mailers.smtp.port');

        if (empty($host) || empty($port)) {
            return [
                'success' => false,
                'message' => 'Configuration SMTP incomplète (hôte ou port manquant)'
            ];
        }

        $timeout = 10;
        $connection = @fsockopen($host, $port, $errno, $errstr, $timeout);

        if (!$connection) {
            return [
                'success' => false,
                'message' => "Impossible de se connecter au serveur SMTP: $errstr ($errno)"
            ];
        }

        fclose($connection);

        return [
            'success' => true,
            'message' => "Connexion au serveur SMTP établie avec succès"
        ];
    }
}
