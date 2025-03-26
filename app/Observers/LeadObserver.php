<?php

namespace App\Observers;

use App\Models\Lead;
use App\Services\AirtableService;
use Illuminate\Support\Facades\Log;

class LeadObserver
{
    protected $airtableService;

    public function __construct(AirtableService $airtableService)
    {
        $this->airtableService = $airtableService;
    }

    /**
     * Handle the Lead "created" event.
     */
    public function created(Lead $lead): void
    {
        // Lorsqu'un lead est créé, on l'envoie à Airtable
        try {
            $this->airtableService->sendLeadToAirtable($lead);
            Log::info('Lead envoyé à Airtable après création', ['lead_id' => $lead->id]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi du lead à Airtable', [
                'lead_id' => $lead->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle the Lead "updated" event.
     */
    public function updated(Lead $lead): void
    {
        // Lorsqu'un lead est mis à jour, on met également à jour les données dans Airtable
        try {
            $this->airtableService->updateLeadInAirtable($lead);
            Log::info('Lead mis à jour dans Airtable', ['lead_id' => $lead->id]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du lead dans Airtable', [
                'lead_id' => $lead->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle the Lead "deleted" event.
     */
    public function deleted(Lead $lead): void
    {
        // Nous pourrions implémenter une logique pour supprimer également dans Airtable
        // Mais pour l'instant, nous ne le faisons pas pour garder une trace
        Log::info('Lead supprimé localement, mais conservé dans Airtable', [
            'lead_id' => $lead->id,
            'airtable_id' => $lead->airtable_id
        ]);
    }

    /**
     * Handle the Lead "restored" event.
     */
    public function restored(Lead $lead): void
    {
        //
    }

    /**
     * Handle the Lead "force deleted" event.
     */
    public function forceDeleted(Lead $lead): void
    {
        //
    }
}
