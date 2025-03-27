<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lead extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'birth_date',
        'address',
        'postal_code',
        'city',
        'department',
        'location_type',
        'energy_bill',
        'is_owner',
        'property_type',
        'property_size',
        'household_status',
        'heating_type',
        'roof_insulated',
        'roof_material',
        'installation_type',
        'panel_size',
        'pac_type',
        'accept_aid',
        'household_count',
        'annual_income',
        'appointment_date',
        'appointment_id',
        'optin',
        'ip_address',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'status',
        'sale_status',
        'comment',
        'airtable_id',
    ];

    /**
     * Les attributs qui doivent être convertis.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_owner' => 'boolean',
        'roof_insulated' => 'boolean',
        'accept_aid' => 'boolean',
        'optin' => 'boolean',
        'appointment_date' => 'date',
        'birth_date' => 'date',
    ];

    /**
     * Retourne le nom complet du lead.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Vérifie si le lead est qualifié selon les critères du projet.
     *
     * @return bool
     */
    public function isQualified(): bool
    {
        // Critères de qualification:
        // - propriétaire
        // - type de logement maison
        // - statut de foyer CDI ou retraité ou indépendant
        return $this->is_owner &&
               $this->property_type === 'maison' &&
               in_array($this->household_status, ['cdi', 'retraite', 'independant']);
    }

    /**
     * Relation avec les visites.
     */
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    /**
     * Récupère la première visite associée à ce lead.
     */
    public function firstVisit()
    {
        return $this->visits()->orderBy('created_at')->first();
    }

    /**
     * Récupère les informations UTM de la première visite.
     */
    public function getUtmDataAttribute()
    {
        $visit = $this->firstVisit();

        if (!$visit) {
            return [
                'source' => $this->utm_source ?? 'Non renseigné',
                'medium' => $this->utm_medium ?? 'Non renseigné',
                'campaign' => $this->utm_campaign ?? 'Non renseigné'
            ];
        }

        return [
            'source' => $visit->utm_source ?? 'Non renseigné',
            'medium' => $visit->utm_medium ?? 'Non renseigné',
            'campaign' => $visit->utm_campaign ?? 'Non renseigné'
        ];
    }

    /**
     * Synchronise le lead actuel avec la plateforme centrale.
     *
     * @return bool
     */
    public function syncWithCentralPlatform(): bool
    {
        try {
            $apiToken = config('services.central_platform.api_token');
            $apiUrl = config('services.central_platform.url') . '/api/v1/leads/sync';

            if (!$apiToken || !$apiUrl) {
                \Log::error('Configuration de la plateforme centrale manquante');
                return false;
            }

            $client = new \GuzzleHttp\Client();
            $response = $client->post($apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'original_id' => $this->id,
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'postal_code' => $this->postal_code,
                    'city' => $this->city,
                    'energy_type' => $this->energy_type,
                    'property_type' => $this->property_type,
                    'is_owner' => $this->is_owner,
                    'has_project' => $this->has_project,
                    'appointment_date' => $this->appointment_date ? $this->appointment_date->format('Y-m-d') : null,
                    'appointment_id' => $this->appointment_id,
                    'optin' => $this->optin,
                    'ip_address' => $this->ip_address,
                    'utm_source' => $this->utm_source,
                    'utm_medium' => $this->utm_medium,
                    'utm_campaign' => $this->utm_campaign,
                    'status' => $this->status,
                    'sale_status' => $this->sale_status,
                    'comment' => $this->comment,
                    'airtable_id' => $this->airtable_id,
                ]
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody(), true);

            if ($statusCode === 200 || $statusCode === 201) {
                \Log::info('Lead #' . $this->id . ' synchronisé avec la plateforme centrale');
                return true;
            } else {
                \Log::error('Erreur lors de la synchronisation du lead #' . $this->id . ' avec la plateforme centrale', [
                    'status_code' => $statusCode,
                    'response' => $body
                ]);
                return false;
            }
        } catch (\Exception $e) {
            \Log::error('Exception lors de la synchronisation du lead #' . $this->id . ' avec la plateforme centrale', [
                'exception' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Alias pour syncWithCentralPlatform pour compatibilité avec le job.
     *
     * @return bool
     */
    public function syncWithPlatform(): bool
    {
        return $this->syncWithCentralPlatform();
    }
}
