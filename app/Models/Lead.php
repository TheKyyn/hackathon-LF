<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'address',
        'postal_code',
        'city',
        'energy_type',
        'property_type',
        'is_owner',
        'has_project',
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
        'has_project' => 'boolean',
        'optin' => 'boolean',
        'appointment_date' => 'date',
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
        // Critères de qualification: propriétaire, maison individuelle, a un projet
        return $this->is_owner &&
               $this->property_type === 'maison_individuelle' &&
               $this->has_project;
    }
}
