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
}
