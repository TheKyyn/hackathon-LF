<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Lead;

class AirtableService
{
    protected $apiKey;
    protected $baseId;
    protected $tableName;
    protected $apiUrl;

    /**
     * Initialise le service Airtable avec les informations d'authentification
     */
    public function __construct()
    {
        $this->apiKey = env('AIRTABLE_API_KEY');
        $this->baseId = env('AIRTABLE_BASE_ID');
        $this->tableName = env('AIRTABLE_TABLE', 'Maxime');
        $this->apiUrl = "https://api.airtable.com/v0/{$this->baseId}/{$this->tableName}";
    }

    /**
     * Convertit un objet Lead en format pour Airtable
     *
     * @param Lead $lead L'objet Lead à convertir
     * @return array Les données formatées pour Airtable
     */
    protected function formatLeadForAirtable(Lead $lead): array
    {
        $data = [
            'fields' => [
                'Prenom' => $lead->first_name ?: 'Non renseigné',
                'Nom' => $lead->last_name ?: 'Non renseigné',
                'Email' => $lead->email,
                'Phone' => $lead->phone,
                'Type de chauffage' => $lead->energy_type ?: 'Non renseigné',
                'CE' => $lead->energy_bill ?: 'Non renseigné',
                'Propriétaire' => $lead->is_owner ? 'Oui' : 'Non',
                'CDI ?' => $lead->professional_situation == 'stable' ? 'Oui' : 'Non',
                'Crédit' => isset($lead->has_credits) ? ($lead->has_credits ? 'Oui' : 'Non') : 'Non renseigné'
            ]
        ];

        // Ajouter les champs conditionnels s'ils existent
        if ($lead->birth_date && !empty($lead->birth_date)) {
            // Calculer l'âge à partir de la date de naissance
            try {
                $birthDate = new \DateTime($lead->birth_date);
                $today = new \DateTime();
                $age = $birthDate->diff($today)->y;
                $data['fields']['Age'] = $age;
            } catch (\Exception $e) {
                Log::warning("Impossible de calculer l'âge à partir de la date de naissance", [
                    'lead_id' => $lead->id,
                    'birth_date' => $lead->birth_date,
                    'error' => $e->getMessage()
                ]);
            }
        }

        if (isset($lead->income) && $lead->income) {
            $data['fields']['Revenu fiscal'] = $lead->income;
        }

        return $data;
    }

    /**
     * Envoie un lead à Airtable
     *
     * @param Lead $lead L'objet Lead à envoyer
     * @return bool Succès ou échec de l'envoi
     */
    public function sendLeadToAirtable(Lead $lead): bool
    {
        if (!$this->apiKey || !$this->baseId) {
            Log::warning('Configuration Airtable incomplète');
            return false;
        }

        try {
            $data = $this->formatLeadForAirtable($lead);
            Log::info("Données formatées pour Airtable", [
                'lead_id' => $lead->id,
                'data' => $data
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, $data);

            Log::info("Réponse d'Airtable", [
                'lead_id' => $lead->id,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $recordId = $response->json('id');
                Log::info("Lead envoyé à Airtable avec succès", [
                    'lead_id' => $lead->id,
                    'airtable_record_id' => $recordId
                ]);

                // Optionnel : sauvegarder l'ID Airtable sur le lead pour référence future
                $lead->airtable_id = $recordId;
                $lead->save();

                return true;
            } else {
                Log::error("Erreur lors de l'envoi à Airtable", [
                    'lead_id' => $lead->id,
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error("Exception lors de l'envoi à Airtable: " . $e->getMessage(), [
                'lead_id' => $lead->id,
                'exception' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Met à jour un lead dans Airtable
     *
     * @param Lead $lead L'objet Lead à mettre à jour
     * @return bool Succès ou échec de la mise à jour
     */
    public function updateLeadInAirtable(Lead $lead): bool
    {
        if (!$lead->airtable_id) {
            return $this->sendLeadToAirtable($lead);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->patch($this->apiUrl . '/' . $lead->airtable_id, $this->formatLeadForAirtable($lead));

            if ($response->successful()) {
                Log::info("Lead mis à jour dans Airtable avec succès", [
                    'lead_id' => $lead->id,
                    'airtable_record_id' => $lead->airtable_id
                ]);
                return true;
            } else {
                Log::error("Erreur lors de la mise à jour dans Airtable", [
                    'lead_id' => $lead->id,
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error("Exception lors de la mise à jour dans Airtable: " . $e->getMessage(), [
                'lead_id' => $lead->id,
                'exception' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
}
