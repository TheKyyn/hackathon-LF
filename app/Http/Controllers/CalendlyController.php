<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\TwilioService;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CalendlyController extends Controller
{
    protected $twilioService;
    protected $emailService;
    protected $calendlyApiKey;
    protected $calendlyUrl;

    /**
     * Initialise le contrôleur avec les services nécessaires
     */
    public function __construct(TwilioService $twilioService, EmailService $emailService)
    {
        $this->twilioService = $twilioService;
        $this->emailService = $emailService;
        $this->calendlyApiKey = env('CALENDLY_API_KEY');
        $this->calendlyUrl = env('CALENDLY_URL', 'https://calendly.com/la-factory-lead');
    }

    /**
     * Affiche la page de prise de rendez-vous Calendly.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        $leadId = $request->input('lead_id');
        $lead = Lead::findOrFail($leadId);

        return view('calendly', [
            'lead' => $lead,
            'calendlyUrl' => $this->calendlyUrl
        ]);
    }

    /**
     * Traitement du webhook Calendly.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function webhook(Request $request)
    {
        try {
            // Valider la signature du webhook (à améliorer pour la production)
            $payload = $request->all();
            Log::info('Webhook Calendly reçu', ['event' => $payload['event'] ?? 'inconnu']);

            // Traiter les données du webhook uniquement si c'est un événement de création de rendez-vous
            if (isset($payload['event']) && $payload['event'] === 'invitee.created') {
                $invitee = $payload['payload']['invitee'] ?? null;
                $event = $payload['payload']['event'] ?? null;

                if (!$invitee || !$event) {
                    return response()->json(['status' => 'error', 'message' => 'Données invalides']);
                }

                // Trouver le lead associé à cet email
                $lead = Lead::where('email', $invitee['email'])->first();

                if (!$lead) {
                    Log::warning('Rendez-vous Calendly pour un email inconnu', ['email' => $invitee['email']]);
                    return response()->json(['status' => 'error', 'message' => 'Lead non trouvé']);
                }

                // Mettre à jour les informations du rendez-vous
                $lead->appointment_date = $event['start_time'];
                $lead->appointment_id = $invitee['uuid'];
                $lead->status = 'appointment_scheduled';
                $lead->save();

                Log::info('Rendez-vous Calendly enregistré', [
                    'lead_id' => $lead->id,
                    'appointment_date' => $event['start_time']
                ]);

                // Envoyer un email de confirmation
                $this->emailService->sendAppointmentConfirmation($lead, $event['start_time']);

                // Envoyer un SMS de confirmation
                $this->twilioService->sendAppointmentConfirmation($lead, $event['start_time']);

                // Programmer l'envoi d'un rappel 24h avant le rendez-vous (à implémenter avec une tâche planifiée)
                // Pour le hackathon, on simule un envoi immédiat
                if (config('app.env') === 'local') {
                    Log::info('Simulation d\'envoi de rappel pour le hackathon');
                    $this->emailService->sendAppointmentReminder($lead);
                    $this->twilioService->sendAppointmentReminder($lead);
                }

                return response()->json(['status' => 'success', 'message' => 'Rendez-vous traité avec succès']);
            }

            return response()->json(['status' => 'ignored', 'message' => 'Événement ignoré']);
        } catch (\Exception $e) {
            Log::error('Erreur traitement webhook Calendly: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Affiche la page de confirmation après la prise de rendez-vous.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function confirmation(Request $request)
    {
        $leadId = $request->input('lead_id');
        $lead = Lead::findOrFail($leadId);

        return view('confirmation', [
            'lead' => $lead
        ]);
    }
}
