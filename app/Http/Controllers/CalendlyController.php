<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class CalendlyController extends Controller
{
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

        // Définir les paramètres pour Calendly
        $calendlyUrl = 'https://calendly.com/la-factory-lead';

        return view('calendly', [
            'lead' => $lead,
            'calendlyUrl' => $calendlyUrl
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
        // Valider la signature du webhook (à implémenter)

        $payload = $request->all();

        // Traiter les données du webhook
        if ($payload['event'] === 'invitee.created') {
            $invitee = $payload['payload']['invitee'];
            $event = $payload['payload']['event'];

            // Trouver le lead associé à cet email
            $lead = Lead::where('email', $invitee['email'])->first();

            if ($lead) {
                // Mettre à jour les informations du rendez-vous
                $lead->appointment_date = $event['start_time'];
                $lead->appointment_id = $invitee['uuid'];
                $lead->save();

                // Ici, on pourrait envoyer un email de confirmation
                // et programmer un SMS de rappel via Twilio
            }
        }

        return response()->json(['status' => 'success']);
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
